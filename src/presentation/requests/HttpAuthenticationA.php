<?php
namespace vsc\presentation\requests;

use vsc\infrastructure\BaseObject;

abstract class HttpAuthenticationA extends BaseObject {
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

	public static function getAuthenticationSchemas($iType) {
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
