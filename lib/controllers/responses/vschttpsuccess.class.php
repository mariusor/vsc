<?php
/**
 * @package vsc_controllers
 * @subpackage vsc_response
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscHttpSuccess extends vscHttpResponseA {
	protected $aStatusList = array (
		200 => '200 OK',
		204 => '204 No Content',
	);

	public function setHeaders () {
		header ($this->getServerProtocol() . ' ' . $this->getStatus (200));
	}
	public function getOutput () {
		$this->setHeaders ();
		return 'test';
	}
}