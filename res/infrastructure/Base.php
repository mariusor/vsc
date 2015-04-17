<?php
/**
 * @package lib_infrastructure
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.03.30
 */
namespace vsc\infrastructure;

class Base extends Object {
	public function __call($sMethodName, $aVars) {
		if (stristr($sMethodName, 'get')) {
			// we have a getter we return $this
			return new static();
		} elseif (!stristr($sMethodName, 'set')) {
			return parent::__call($sMethodName, $aVars);
		}
		return null;
	}

	public function __get($sVarName) {
		return new self();
	}

	public function __toString() {
		return '';
	}
}
