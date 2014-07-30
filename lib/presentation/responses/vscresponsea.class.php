<?php
namespace vsc\presentation\responses;

class vscResponseA extends vscNull {

	/**
	 * @param $oBody vscViewA
	 * @return string
	 */
	public function setView (vscViewI $oView) {
		$this->oView = $oView;
	}

	public function getView() {
		if (!vscViewA::isValid($this->oView)) {
			$this->oView = new vscNull();
		}
		return $this->oView;
	}

	public function getOutput() {
		$sResponseBody = null;
		if (vscViewA::isValid($this->getView())) {
			$this->setContentType($this->getView()->getContentType());
		} else {
			$this->setContentType('*/*');
		}

		if (!vsc::getEnv()->getHttpRequest()->isHead() && !$this->isRedirect()) {
			$sResponseBody = $this->getView()->getOutput();
		}
		return $sResponseBody;
	}
}
