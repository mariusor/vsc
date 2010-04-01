<?php
/**
 * @package lib_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.03.30
 */
import (VSC_LIB_PATH . 'exceptions');
abstract class vscObject {
	public function __call ($sMethodName, $aVars) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new vscExceptionUnimplemented ('Method [' . get_class($this) .'::' . $sMethodName .'] not implemented for calling.');
		} else {
			return $this;
		}
	}

	public function __callStatic ($sMethodName, $aVars) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new vscExceptionUnimplemented ('Method [' . get_class($this) .'::' . $sMethodName .'] not implemented for calling statically.');
		} else {
			return $this;
		}
	}

	public function __get ($sVarName) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new vscExceptionUnimplemented ('Property [' . get_class($this) .'::' . $sVarName .'] not implemented for reading.');
		} else {
			return $this;
		}
	}

	public function __set ($sVarName, $mValue) {
		if (vsc::getEnv()->isDevelopment()) {
			throw new vscExceptionUnimplemented ('Property [' . get_class($this) .'::' . $sVarName .'] not implemented for writing.');
		} else {
			return $this;
		}
	}
}