<?php
/**
 * @package vsc_presentation
 * @subpackage vsc_response
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
class vscHttpRedirection extends vscHttpResponseA {
	private $sLocation;
	protected $aStatusList = array (
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other',
		304 => '304 Not Modified',
	);

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setLocation ($sValue){
		$this->sLocation = $sValue;
	}

	/**
	 * @return string
	 */
	public function getLocation (){
		return $this->sLocation;
	}

	public function outputHeaders () {
		parent::outputHeaders();
		$sLocation = $this->getLocation();
		if ($sLocation) {
			header ('Location:' . $sLocation);
		}
	}

	public function getOutput () {
		$this->outputHeaders ();
		return null;
	}
}