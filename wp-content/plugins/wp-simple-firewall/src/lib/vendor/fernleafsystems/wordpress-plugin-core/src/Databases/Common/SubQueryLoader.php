<?php

namespace FernleafSystems\Wordpress\Plugin\Core\Databases\Common;

use FernleafSystems\Wordpress\Plugin\Core\Databases\Base\{
	BaseQuery,
	Delete,
	Insert,
	Record,
	Select,
	Update
};
use FernleafSystems\Wordpress\Services\Utilities\Autoloading\FindClassFromNamespaceRoots;

class SubQueryLoader {

	use HandlerConsumer;

	public function loadClass( string $class ) {
		/** @var BaseQuery $o */
		$o = new $class();
		return $o->setDbH( $this->getDbH() );
	}

	/**
	 * @return Delete|mixed
	 */
	public function delete() {
		return $this->loadClass(
			FindClassFromNamespaceRoots::Find( 'Delete', $this->getNamespaceRoots() )
		);
	}

	/**
	 * @return Insert|mixed
	 */
	public function insert() {
		return $this->loadClass(
			FindClassFromNamespaceRoots::Find( 'Insert', $this->getNamespaceRoots() )
		);
	}

	/**
	 * @return Record|mixed
	 */
	public function record() {
		return $this->loadClass(
			FindClassFromNamespaceRoots::Find( 'Record', $this->getNamespaceRoots() )
		);
	}

	/**
	 * @return Select|mixed
	 */
	public function select() {
		return $this->loadClass(
			FindClassFromNamespaceRoots::Find( 'Select', $this->getNamespaceRoots() )
		);
	}

	/**
	 * @return Update|mixed
	 */
	public function update() {
		return $this->loadClass(
			FindClassFromNamespaceRoots::Find( 'Update', $this->getNamespaceRoots() )
		);
	}

	protected function getNamespaceRoots() :array {
		$roots = $this->getDbH()->getBaseNamespaces();
		\array_unshift( $roots, $this->getPrimaryNamespace() );
		return $roots;
	}

	private function getPrimaryNamespace() :string {
		try {
			$namespace = ( new \ReflectionClass( $this->getDbH() ) )->getNamespaceName();
		}
		catch ( \Exception $e ) {
			$namespace = __NAMESPACE__;
		}
		return \rtrim( $namespace, '\\' );
	}
}