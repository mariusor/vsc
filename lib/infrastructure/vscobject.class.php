<?php
/**
 * @package lib_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.03.30
 */
import (VSC_LIB_PATH . 'exceptions');
abstract class vscObject {
	public function __call ($sMethodName, $aVars) {
		throw new vscExceptionUnimplemented ('Method [' . get_class($this) .'::' . $sMethodName .'] not implemented for calling.');
	}

	public function __callStatic ($sMethodName, $aVars) {
		throw new vscExceptionUnimplemented ('Method [' . get_class($this) .'::' . $sMethodName .'] not implemented for calling statically.');
	}

	public function __get ($sVarName) {
		throw new vscExceptionUnimplemented ('Property [' . get_class($this) .'::' . $sVarName .'] not implemented for reading.');
	}

	public function __set ($sVarName, $mValue) {
		throw new vscExceptionUnimplemented ('Property [' . get_class($this) .'::' . $sVarName .'] not implemented for writing.');
	}
}