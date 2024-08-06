<?php

namespace FernleafSystems\Utilities\Logic;

trait ExecOnce {

	private $hasExecuted = false;

	protected function canRun() :bool {
		return true;
	}

	public function execute() {
		if ( !$this->isAlreadyExecuted() && $this->canRun() ) {
			$this->hasExecuted = true;
			$this->run();
		}
	}

	protected function isAlreadyExecuted() :bool {
		return (bool)$this->hasExecuted;
	}

	public function resetExecution() {
		$this->hasExecuted = false;
		return $this;
	}

	protected function run() {
	}
}