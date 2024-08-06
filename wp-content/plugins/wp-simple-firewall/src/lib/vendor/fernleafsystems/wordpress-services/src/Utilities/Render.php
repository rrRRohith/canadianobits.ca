<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\File\Paths;
use FernleafSystems\Wordpress\Services\Utilities\Twig\Extensions\FilterBase64;

class Render {

	public const TEMPLATE_ENGINE_TWIG = 0;
	public const TEMPLATE_ENGINE_PHP = 1;
	public const TEMPLATE_ENGINE_HTML = 2;

	/**
	 * @var array
	 */
	protected $aRenderVars;

	/**
	 * @var array
	 */
	protected $renderVars = [];

	/**
	 * @var array
	 */
	protected $aTemplateRoots;

	/**
	 * @var array
	 */
	protected $aTwigTemplateRoots;

	/**
	 * @var array
	 */
	protected $twigTemplateRoots = [];

	/**
	 * @var string
	 */
	protected $template;

	/**
	 * @var string
	 */
	protected $sTemplate;

	/**
	 * @var int
	 */
	protected $nTemplateEngine;

	/**
	 * @var array
	 */
	private $twigEnvVariables = [];

	public function render() :string {
		switch ( $this->getTemplateEngine() ) {
			case self::TEMPLATE_ENGINE_TWIG :
				$output = $this->renderTwig();
				break;
			case self::TEMPLATE_ENGINE_HTML :
				$output = $this->renderHtml();
				break;
			default:
				$output = $this->renderPhp();
				break;
		}
		return $output;
	}

	private function renderHtml() :string {
		\ob_start();
		@include( path_join( $this->getTemplateRoot(), $this->getTemplate() ) );
		return (string)\ob_get_clean();
	}

	private function renderPhp() :string {
		if ( \count( $this->getRenderVars() ) > 0 ) {
			\extract( $this->getRenderVars() );
		}

		$template = path_join( $this->getTemplateRoot(), $this->getTemplate() );
		if ( Services::WpFs()->isFile( $template ) ) {
			\ob_start();
			include( $template );
			$contents = \ob_get_clean();
		}
		else {
			$contents = 'Error: Template file not found: '.$template;
		}

		return (string)$contents;
	}

	private function renderTwig() :string {
		try {
			$env = $this->getTwigEnvironment();
			/**
			foreach ( $this->enumExtensions() as $enumExtension ) {
				$env->addExtension( new $enumExtension() );
			}*/
			do_action( 'apto/services/pre_render_twig', $env );
			return $env->render( $this->getTemplate(), $this->getRenderVars() );
		}
		catch ( \Exception $e ) {
			return 'Could not render Twig with following Exception: '.$e->getMessage();
		}
	}

	public function display() :self {
		echo $this->render();
		return $this;
	}

	public function clearRenderVars() :self {
		return $this->setRenderVars( [] );
	}

	/**
	 * @return string[]|\Twig\Extension\AbstractExtension[]
	 */
	public function enumExtensions() :array {
		return [
			FilterBase64::class,
		];
	}

	/**
	 * @return \Twig_Environment
	 */
	private function getTwigEnvironment() {
		$cfg = \array_merge( [
			'debug'            => true,
			'strict_variables' => true,
		], $this->twigEnvVariables );

		if ( @\class_exists( 'Twig_Environment' ) ) {
			$env = new \Twig_Environment( new \Twig_Loader_Filesystem( $this->getTemplateRoots() ), $cfg );
		}
		else {
			$env = new \Twig\Environment( new \Twig\Loader\FilesystemLoader( $this->getTemplateRoots() ), $cfg );
		}
		return $env;
	}

	public function getTemplate() :string {
		$t = $this->template ?? $this->sTemplate;
		return Paths::AddExt( (string)$t, $this->getEngineStub() );
	}

	/**
	 * @return int
	 */
	public function getTemplateEngine() {
		if ( !isset( $this->nTemplateEngine )
			 || !\in_array( $this->nTemplateEngine, [
				self::TEMPLATE_ENGINE_TWIG,
				self::TEMPLATE_ENGINE_PHP,
				self::TEMPLATE_ENGINE_HTML
			] ) ) {
			$this->nTemplateEngine = self::TEMPLATE_ENGINE_PHP;
		}
		return $this->nTemplateEngine;
	}

	/**
	 * @param string $template
	 */
	public function getTemplateExists( $template = '' ) :bool {
		return \strlen( $this->getTemplateRoot( $template ) ) > 0;
	}

	/**
	 * @param string $template
	 * @return string
	 */
	public function getTemplateRoot( $template = '' ) {
		$root = '';
		$template = empty( $template ) ? $this->getTemplate() : $template;
		foreach ( $this->getTemplateRoots() as $possible ) {
			if ( Services::WpFs()->exists( path_join( $possible, $template ) ) ) {
				$root = $possible;
				break;
			}
		}
		return $root;
	}

	public function getTemplateRoots() :array {
		$roots = \array_map(
			function ( $root ) {
				return path_join( $root, $this->getEngineStub() );
			},
			$this->getTemplateRootsPlain()
		);
		if ( $this->getTemplateEngine() === self::TEMPLATE_ENGINE_TWIG ) {
			$roots = \array_merge( $this->getTwigTemplateRoots(), $roots );
		}
		return \array_unique( \array_map( '\trailingslashit', \array_filter( $roots ) ) );
	}

	/**
	 * @return array
	 */
	private function getTemplateRootsPlain() {
		if ( !is_array( $this->aTemplateRoots ) ) {
			$this->aTemplateRoots = [];
		}
		return $this->aTemplateRoots;
	}

	private function getTwigTemplateRoots() :array {
		$roots = $this->twigTemplateRoots ?? $this->aTwigTemplateRoots;
		return \is_array( $roots ) ? $roots : [];
	}

	public function getRenderVars() :array {
		$vars = $this->renderVars ?? $this->aRenderVars;
		return \is_array( $vars ) ? $vars : [];
	}

	/**
	 * @param array $vars
	 * @return $this
	 */
	public function setRenderVars( $vars ) {
		$this->renderVars = $vars;
		if ( property_exists( $this, 'aRenderVars' ) ) {
			$this->aRenderVars = $vars;
		}
		return $this;
	}

	/**
	 * @param string $templatePath
	 * @return $this
	 */
	public function setTemplate( $templatePath ) {
		$this->template = $templatePath;
		if ( property_exists( $this, 'sTemplate' ) ) {
			$this->sTemplate = $templatePath;
		}
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setTemplateEngineHtml() {
		return $this->setTemplateEngine( self::TEMPLATE_ENGINE_HTML );
	}

	/**
	 * @return $this
	 */
	public function setTemplateEnginePhp() {
		return $this->setTemplateEngine( self::TEMPLATE_ENGINE_PHP );
	}

	/**
	 * @return $this
	 */
	public function setTemplateEngineTwig() {
		return $this->setTemplateEngine( self::TEMPLATE_ENGINE_TWIG );
	}

	/**
	 * @param int $nEngine
	 * @return $this
	 */
	protected function setTemplateEngine( $nEngine ) {
		$this->nTemplateEngine = $nEngine;
		return $this;
	}

	/**
	 * @param string $sPath
	 * @return $this
	 */
	public function setTemplateRoot( $sPath ) {
		if ( !empty( $sPath ) ) {
			$aTemps = $this->getTemplateRootsPlain();
			$aTemps[] = $sPath;
			$this->aTemplateRoots = \array_unique( $aTemps );
		}
		return $this;
	}

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setTwigTemplateRoot( $path ) :self {
		if ( !empty( $path ) ) {
			$roots = $this->getTwigTemplateRoots();
			$roots[] = $path;
			$this->twigTemplateRoots = \array_unique( $roots );
			if ( property_exists( $this, 'aTwigTemplateRoots' ) ) {
				$this->aTwigTemplateRoots = $this->twigTemplateRoots;
			}
		}
		return $this;
	}

	public function setTwigEnvironmentVars( array $vars ) :self {
		$this->twigEnvVariables = $vars;
		return $this;
	}

	private function getEngineStub() :string {
		switch ( $this->getTemplateEngine() ) {

			case self::TEMPLATE_ENGINE_TWIG:
				$stub = 'twig';
				break;

			case self::TEMPLATE_ENGINE_HTML:
				$stub = 'html';
				break;

			case self::TEMPLATE_ENGINE_PHP:
			default:
				$stub = 'php';
				break;
		}
		return $stub;
	}
}