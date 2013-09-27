<?php
class vscBasicHttpAuthentication extends vscHttpAuthenticationA {

	public function __construct($sUserName = null, $sPassword = null) {
		if (!is_null($sUserName)) {
			$this->setUser($sUserName);
		}
		if (!is_null($sPassword)) {
			$this->setPassword($sPassword);
		}
	}
}