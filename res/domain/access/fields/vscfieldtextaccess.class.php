<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.29
 */
import (VSC_LIB_PATH . 'domain/access/fields');

class vscFieldTextAccess extends vscSqlFieldAccessA {
	public function getType (vscFieldA $oField) {
		if ($oField->getMaxLength() > 255 || $oField->getMaxLength() === null) {
			return 'TEXT';
		} else {
			return 'VARCHAR';
		}
	}

//	protected function escapeValue (vscFieldA $oField) {
//		return $this->getConnection()->escape($oField->getValue());
//	}

	public function getDefinition (vscFieldA $oField) {
		// this is totally wrong for PostgreSQL
		return	$this->getType($oField) .
				($oField->getMaxLength() ? '(' . $oField->getMaxLength() . ')' : '') .
				($oField->getEncoding() ? ' CHARACTER SET ' . $oField->getEncoding() : '') .
				($oField->getDefaultValue() !== null || (!$oField->getIsNullable()) ? $this->getConnection()->_NULL($oField->getIsNullable()) : '').
				($oField->hasDefaultValue() ? ' DEFAULT ' . ($oField->getDefaultValue() === null ? $this->getConnection()->_NULL(true) : $oField->getDefaultValue()) : '');
	}
}