<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.29
 */
import (VSC_LIB_PATH . 'domain/access/fields');

class vscFieldEnumAccess extends vscSqlFieldAccessA {
	public function getType (vscFieldA $oField) {
		return 'ENUM';
	}

//	protected function escapeValue (vscFieldA $oField) {
//		return $this->value;
//	}

//	public function getDefinition (vscFieldA $oField) {
//		return	$oField->getType();
//	}
}
