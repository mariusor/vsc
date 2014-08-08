<?php
namespace vsc\presentation\responses;

class ExceptionResponseRedirect extends ExceptionResponse {
	private $sLocation;
	private $iHttpRedirectCode;

	public function __construct ($sLocation, $iCode = 302) {
		$this->iHttpRedirectCode = $iCode;
		$this->sLocation = $sLocation;
	}

	public function getRedirectCode () {
		return $this->iHttpRedirectCode;
	}

	public function getLocation () {
		return $this->sLocation;
	}
}
