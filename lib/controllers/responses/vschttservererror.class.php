<?php
/**
 * @package vsc_controllers
 * @subpackage vsc_response
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscHttpServerError extends vscHttpResponseA {
	protected $aStatusList = array (
		500 => '500 Internal Server Error',
		501 => '501 Not Implemented',
	);
	public function setHeaders () {
		header ($this->getServerProtocol() . ' '. array_pop ($this->aStatusList));
	}
	public function getOutput () {
		$this->setHeaders ();
		return 'test';
	}
}