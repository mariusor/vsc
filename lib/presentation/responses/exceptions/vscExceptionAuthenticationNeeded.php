<?php
namespace vsc\presentation\responses;

class vscExceptionAuthenticationNeeded extends vscExceptionResponseError {
	private $sRealm;

	public function __construct($sMessage, $sRealm = '') {
		if ( !empty ($sRealm) ) {
			$this->sRealm = $sRealm;
		}
		parent::__construct ($sMessage, 401);
	}

	public function getChallenge () {
		return 'Basic realm="' . $this->sRealm . '"';
	}
}
