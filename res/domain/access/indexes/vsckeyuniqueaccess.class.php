<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.30
 */

import (VSC_LIB_PATH . 'domain/access/indexes');

class vscKeyUniqueAccess extends vscSqlIndexAccessA {
    public function getType(vscIndexA $oIndex) {}
	public function getDefinition (vscIndexA $oIndex) {
		// this is totally wrong for PostgreSQL
		return	'UNIQUE INDEX ' . $oIndex->getName() . ' (' . $oIndex->getIndexComponents(). ')';
	}
}
