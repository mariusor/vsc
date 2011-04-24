<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.13
 */
import (VSC_LIB_PATH . 'domain/domain/fields');

class vscFieldEnum extends vscFieldA {
	protected $values = array();

	public function getType () {
		return vscFieldType::ENUM;
	}

	protected function escape () {
		return $this->value;
	}

	public function setValues  ($mValue) {
		$mValues = func_get_args();
		if (is_array($mValue)) {
			$this->values = $mValue;
		} else if (is_array($mValues)) {
			$this->values = $mValues;
		}
	}

	public function getValues () {
		return $this->values;
	}

	public function setValue($value) {
		if (in_array($value, $this->values)) parent::setValue($value);
		else throw new vscExceptionDomain('Value [' . $value . '] is not valid for field [' . $this->getTableAlias() . '.' . $this->getName() . ']');
	}
}
