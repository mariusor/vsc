<?php
/**
 * @package lib_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.03.30
 */
namespace vsc\infrastructure;

use vsc\ExceptionUnimplemented;

abstract class Object {
	public function __call ($sMethodName, $aVars) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented ('Method [' . get_class($this) .'::' . $sMethodName .'] not implemented for calling.');
		} else {
			return new Null();
		}
	}

	static public function __callStatic ($sMethodName, $aVars) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented ('Method [' . get_class() .'::' . $sMethodName .'] not implemented for calling statically.');
		} else {
			return new Null();
		}
	}

	public function __get ($sVarName) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented ('Property [' . get_class($this) .'::' . $sVarName .'] not implemented for reading.');
		} else {
			return new Null();
		}
	}

	public function __set ($sVarName, $mValue) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new ExceptionUnimplemented ('Property [' . get_class($this) .'::' . $sVarName .'] not implemented for writing.');
		}
	}

	static public function isValid ($oIncomingObject) {
		return (!is_null($oIncomingObject) && $oIncomingObject instanceof static);
	}
}
