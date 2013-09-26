<?php
import ('requests');
class vscCLIRequest extends vscRequestA {
	protected $aVars = array();

	public function __construct () {

	}

	public function getVars () {
	}

	public function getVar ($sVarName) {
		$mValue = parent::getVar($sVarName);
		return $mValue;
	}

	/**
	 * @todo this has to be moved in the rw url handler
	 * @return void
	 */
	public function constructVars () {
		$this->aVars = parse_str($_SERVER['argv']);
	}
}
