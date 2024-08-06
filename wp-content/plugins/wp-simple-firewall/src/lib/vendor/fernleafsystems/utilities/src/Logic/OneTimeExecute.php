<?php

namespace FernleafSystems\Utilities\Logic;

trait OneTimeExecute {

	private $bHasOneTimeExecuted = false;

	/**
	 * @return bool
	 */
	protected function canRun() {
		return true;
	}

	public function execute() {
		if ( !$this->isAlreadyExecuted() && $this->canRun() ) {
			$this->bHasOneTimeExecuted = true;
			$this->run();
		}
	}

	/**
	 * @return bool
	 */
	protected function isAlreadyExecuted() {
		return (bool)$this->bHasOneTimeExecuted;
	}

	/**
	 * @return $this
	 */
	public function resetExecution() {
		$this->bHasOneTimeExecuted = false;
		return $this;
	}

	protected function run() {
	}
}