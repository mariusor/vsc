<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.13
 */
import ('domain/models');
import ('domain/exceptions');
class vscJsonReader extends vscModelA {
	private $sJsonString;

	public function __construct () {
		if (!extension_loaded('json')) {
			throw new vscExceptionUnimplemented('The JSON extension is not loaded');
		}
		parent::__construct();
	}

	public function setString ($sString) {
		$this->sJsonString = $sString;
	}

	public function getString () {
		return $this->sJsonString;
	}

	public function __get ($sIncName) {
		try {
			$oProperty = new ReflectionProperty($this, $sIncName);
			if ($oProperty->isPublic()) {
				return $oProperty->getValue($this);
			}
		} catch (ReflectionException $e) {
			//
		}
		parent::__get ($sIncName);
	}

	public function __set($sIncName, $mValue) {
		if (is_null($sIncName)) {
			throw ReflectionError ('Can\'t set a value to a null property on the current object ['. get_class ($this).']');
		}
		try {
			$oProperty = new ReflectionProperty($this->oPayload, $sIncName);
			if ($oProperty->isPublic()) {
				$oProperty->setValue($this->oPayload, $mValue);
			}
			return;
		} catch (ReflectionException $e) {
			$this->$sIncName = $mValue;
		}
	}

	public function getPayload () {
		return $this->oPayload;
	}

	public function getError ($iError) {
		switch($iLastError) {
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
			throw new vscExceptionDomain('The JSON string contains errors: [' . $this->getError($iLastError) . ']');
		}
	}
}