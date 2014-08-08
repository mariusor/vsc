<?php
/**
 * @package lib_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.03.30
 */
namespace vsc\infrastructure;

class Null extends Object {
	public function __call ($sMethodName, $aVars) {
		if (stristr($sMethodName, 'get')) {
			// we have a getter we return $this
			return new Null();
		} elseif (!stristr($sMethodName, 'set')) {
			parent::__call ($sMethodName, $aVars);
		}
	}

	public function __get ($sVarName) {
		return new Null();
	}

	public function __toString () {
		return '';
	}
}
