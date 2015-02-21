<?php
namespace vsc\presentation\responses;

class ExceptionAuthenticationNeeded extends ExceptionResponseError {
	private $sRealm;

	public function __construct($sMessage, $sRealm = '') {
		if (!empty ($sRealm)) {
			$this->sRealm = $sRealm;
		}
		parent::__construct($sMessage, 401);
	}

	public function getChallenge() {
		return 'Basic realm="'.$this->sRealm.'"';
	}
}
