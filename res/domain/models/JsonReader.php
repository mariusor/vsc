<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.13
 */
namespace vsc\domain\models;

use vsc\domain\ExceptionDomain;
use vsc\ExceptionUnimplemented;

class JsonReader extends ModelA {
	private $sJsonString;

	public function __construct () {
		if (!extension_loaded('json')) {
			throw new ExceptionUnimplemented('The JSON extension is not loaded');
		}
		parent::__construct();
	}

	public function setString ($sString) {
		$this->sJsonString = $sString;
	}

	public function getString () {
		return $this->sJsonString;
	}

	public function __get ($sIncName = null) {
		try {
			$oProperty = new \ReflectionProperty($this, $sIncName);
			if ($oProperty->isPublic()) {
				return $oProperty->getValue($this);
			}
		} catch (\ReflectionException $e) {
			//
		}
		parent::__get ($sIncName);
	}

	public function __set($sIncName, $mValue) {
		if (is_null($sIncName)) {
			throw new \ReflectionException ('Can\'t set a value to a null property on the current object ['. get_class ($this).']');
		}
		try {
			$oProperty = new \ReflectionProperty($this->oPayload, $sIncName);
			if ($oProperty->isPublic()) {
				$oProperty->setValue($this->oPayload, $mValue);
			}
			return;
		} catch (\ReflectionException $e) {
			$this->$sIncName = $mValue;
		}
	}

	public function getPayload () {
		return $this->oPayload;
	}

	static public function getError ($iError) {
		switch($iError) {
		case JSON_ERROR_DEPTH:
			$sLastError = 'Maximum stack depth exceeded';
			break;
		case JSON_ERROR_CTRL_CHAR:
			$sLastError = 'Unexpected control character found';
			break;
		case JSON_ERROR_SYNTAX:
			$sLastError = 'Syntax error, malformed JSON';
			break;
		case JSON_ERROR_NONE:
		default:
			$sLastError = 'No errors';
			break;
		}
		return $sLastError;
	}

	public function buildObj() {
		$oPayload	= json_decode($this->sJsonString);
		$iLastError	= json_last_error();
		if (!$iLastError) {
			foreach ($oPayload as $sName => $oStd) {
				$this->addProperty ($sName, $oStd, true);
			}
		} else {
			throw new ExceptionDomain('The JSON string contains errors: [' . static::getError($iLastError) . ']');
		}
	}
}
