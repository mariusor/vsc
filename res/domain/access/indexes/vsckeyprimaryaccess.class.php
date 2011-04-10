<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.30
 */

import (VSC_LIB_PATH . 'domain/access/indexes');

class vscKeyPrimaryAccess extends vscSqlIndexAccessA {
    public function getType(vscIndexA $oIndex) {}
	public function getDefinition (vscIndexA $oIndex) {
		// this is totally wrong for PostgreSQL
		return	'PRIMARY KEY ' .
		($this->getConnection()->getType() != vscDbType::postgresql ? $oIndex->getName() : '').
		' (' . $oIndex->getIndexComponents(). ')';
	}
}
