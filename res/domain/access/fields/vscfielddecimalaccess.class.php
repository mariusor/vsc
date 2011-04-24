<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
import (VSC_LIB_PATH . 'domain/access/fields');

class vscFieldDecimalAccess extends vscSqlFieldAccessA {
	public function getType (vscFieldA $oField) {
		return 'DECIMAL';
	}

//	public function escapeValue (vscFieldA $oField) {
//		return (int) $oField->getValue();
//	}
//
	public function getDefinition (vscFieldA $oField) {
		// this is totally wrong for PostgreSQL
		return	$this->getType($oField) .
				($oField->getMaxLength() ? '(' . $oField->getMaxLength() . ', ' . $oField->getDecimals() . ')' : '') .
				($oField->getDefaultValue() !== null || (!$oField->getIsNullable()) ? $this->getConnection()->_NULL($oField->getIsNullable()) : '');
	}
}