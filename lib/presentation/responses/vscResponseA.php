<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.09.26
 */
namespace vsc\presentation\responses;

use vsc\infrastructure\vsc;
use vsc\infrastructure\vscNull;
use vsc\presentation\views\vscViewA;

abstract class vscResponseA extends vscNull {
	/**
	 * @var vscViewA
	 */
	private $oView;

	/**
	 * @return boolean
	 */
	abstract function isRedirect();

	/**
	 * @param string $sContentType
	 * @return void
	 */
	abstract function setContentType($sContentType);

	/**
	 * @param vscViewA $oView
	 * @return string
	 */
	public function setView (vscViewA $oView) {
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
