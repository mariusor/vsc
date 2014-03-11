<?php
abstract class vscHttpAuthenticationA extends vscObject {
	const NONE = 0;
	const BASIC = 1;
	const DIGEST = 2;

	protected $Type;

	public $username;
	public $password;

	public function setType($sType) {
		$this->Type = $sType;
	}

	public function getType() {
		return $this->Type;
	}

	public function getUser() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	static public function getAuthenticationSchemas ($iType) {
		$aSchemas = array();
		if ($iType & self::BASIC == $iType) {
			$aSchemas[] = 'Basic';
		}
		if ($iType & self::DIGEST == $iType) {
				$aSchemas[] = 'Digest';
		}
		return $aSchemas;
	}
}
