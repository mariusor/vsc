<?php
/**
 * @package presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2013.09.26
 */
namespace vsc\presentation\responses;

use vsc\infrastructure\vsc;
use vsc\infrastructure\Base;
use vsc\presentation\views\ViewA;

abstract class ResponseA extends Base {
	/**
	 * @var ViewA
	 */
	private $oView;

	/**
	 * @return boolean
	 */
//	abstract function isRedirect();

	/**
	 * @param string $sContentType
	 * @return void
	 */
//	abstract function setContentType($sContentType);

	/**
	 * @param ViewA $oView
	 * @return string
	 */
	public function setView(ViewA $oView) {
		$this->oView = $oView;
	}

	public function getView() {
		if (!ViewA::isValid($this->oView)) {
			$this->oView = new Base();
		}
		return $this->oView;
	}

	public function getOutput() {
		$sResponseBody = null;
		if (ViewA::isValid($this->getView())) {
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
