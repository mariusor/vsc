<?php
namespace vsc\presentation\responses;

class ExceptionDigestAuthenticationChallenge extends ExceptionAuthenticationNeeded {
	private $sRealm;
	private $sNonce;
	public function __construct($sMessage, $sRealm, $sNonce) {
		$this->sRealm = $sRealm;
		$this->sNonce = $sNonce;

		parent::__construct($sMessage, 401);
	}

	public function getChallenge() {
		return 'Digest realm="'.$this->sRealm.'",qop="auth",nonce="'.$this->sNonce.'",opaque="'.md5($this->sRealm).'"';
	}
}
