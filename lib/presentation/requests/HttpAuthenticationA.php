<?php
namespace vsc\presentation\requests;

use vsc\infrastructure\Object;

abstract class HttpAuthenticationA extends Object {
	const NONE = 0;
	const BASIC = 2;
	const DIGEST = 4;

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
		if (($iType & self::BASIC) == self::BASIC) {
			$aSchemas[] = 'Basic';
		}
		if (($iType & self::DIGEST) == self::DIGEST) {
				$aSchemas[] = 'Digest';
		}
		return $aSchemas;
	}
}
