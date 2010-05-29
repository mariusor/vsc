<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.29
 */

import (VSC_LIB_PATH . 'domain/access/fields');

class vscFieldDateTimeAccess extends vscSqlFieldAccessA {
	public function getType (vscFieldA $oField) {
		return 'DATETIME';
	}

//	protected function escapeValue (vscFieldA $oField) {
//		// need a mechanism based on the connection type
//		// TODO
//		return $this->value;
//	}
}