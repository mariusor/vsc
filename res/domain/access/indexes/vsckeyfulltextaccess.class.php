<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.30
 */

import (VSC_LIB_PATH . 'domain/access/indexes');

class vscKeyFullTextAccess extends vscSqlIndexAccessA {
    public function getType(vscIndexA $oIndex) {}

	/**
	 * @todo make sure we don't take into account this type of index for other than mysql with myIsam
	 */
	public function getDefinition (vscIndexA $oIndex) {
		// this is totally wrong for PostgreSQL
		return	'FULLTEXT INDEX ' . $oIndex->getName() . ' (' . $oIndex->getIndexComponents(). ')';
	}
}
