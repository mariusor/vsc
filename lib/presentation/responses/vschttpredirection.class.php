<?php
/**
 * @package vsc_presentation
 * @subpackage vsc_response
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscHttpRedirection extends vscHttpResponseA {
	protected $aStatusList = array (
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other',
		304 => '304 Not Modified',
	);
	public function setHeaders () {
		header ($this->getServerProtocol() . $this->getStatus (303));
	}
	public function getOutput () {
		$this->setHeaders ();
		return null;
	}
}