<?php
import ('coreexceptions');
class vscExceptionResponseRedirect extends vscException {
	private $sLocation;
	private $iHttpRedirectCode;

	public function __construct ($sLocation, $iCode = 302) {
		$this->iHttpRedirectCode = $iCode;
		$this->sLocation = $sLocation;

		parent::__construct ($sLocation, $iCode);
	}

	public function getRedirectCode () {
		return $this->iHttpRedirectCode;
	}

	public function getLocation () {
		return $this->sLocation;
	}
}