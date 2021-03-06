<?php
/**
 * @package lib_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.03.30
 */
namespace vsc\infrastructure;

use vsc\ExceptionUnimplemented;

abstract class BaseObject {
	public function __call($sMethodName, $aVars) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented('Method [' . get_class($this) . '::' . $sMethodName . '] not implemented for calling.');
		} else {
			return new Base();
		}
	}

	public static function __callStatic($sMethodName, $aVars) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented('Method [' . get_class() . '::' . $sMethodName . '] not implemented for calling statically.');
		} else {
			return new Base();
		}
	}

	public function __get($sVarName) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented('Property [' . get_class($this) . '::' . $sVarName . '] not implemented for reading.');
		} else {
			return new Base();
		}
	}

	public function __set($sVarName, $mValue) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented('Property [' . get_class($this) . '::' . $sVarName . '] not implemented for writing.');
		}
	}

	public static function isValid($oIncomingObject) {
		return (!is_null($oIncomingObject) && ($oIncomingObject instanceof static));
	}
}
