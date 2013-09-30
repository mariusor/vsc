<?php
class vscBasicHttpAuthentication extends vscHttpAuthenticationA {
	protected $Type = vscHttpAuthenticationA::BASIC;

	public function __construct($sUserName = null, $sPassword = null) {
		if (!is_null($sUserName)) {
			$this->username = $sUserName;
		}
		if (!is_null($sPassword)) {
			$this->password = $sPassword;
		}
	}
}
