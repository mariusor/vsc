<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
import (VSC_LIB_PATH . 'domain/access/fields');

class vscFieldIntegerAccess extends vscSqlFieldAccessA {
	public function getType (vscFieldA $oField) {
		return 'INTEGER';
	}

//	public function escapeValue (vscFieldA $oField) {
//		return (int) $oField->getValue();
//	}
//
	public function getDefinition (vscFieldA $oField) {
		// this is totally wrong for PostgreSQL

		return	$this->getType($oField) .
				($this->getConnection()->getType() != vscConnectionType::postgresql ? ($oField->getMaxLength() ? '(' . $oField->getMaxLength() . ')' : '') : '').
				($oField->getDefaultValue() !== null || (!$oField->getIsNullable()) ? $this->getConnection()->_NULL($oField->getIsNullable()) : '').
				($oField->hasDefaultValue() ? ' DEFAULT ' . ($oField->getDefaultValue() === null ? $this->getConnection()->_NULL(true) : $oField->getDefaultValue()) : '').
				($this->getConnection()->getType() != vscConnectionType::postgresql ? ($oField->getAutoIncrement() ? ' AUTO_INCREMENT' : '') : '');
	}
}