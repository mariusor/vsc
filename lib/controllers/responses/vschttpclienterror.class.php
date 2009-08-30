<?php
/**
 * @package vsc_controllers
 * @subpackage vsc_response
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscHttpClientError extends vscHttpResponseA {
	protected $aStatusList = array (
		403 => '403 Forbidden',
		404 => '404 Not Found',
		415 => '415 Unsupported Media Type',
		426 => '426 Update Required',
	);

	public function setHeaders () {
		header ($this->getServerProtocol() . $this->getStatus (404));
	}
	public function getOutput () {
		$this->setHeaders ();
		return 'test';
	}
}