<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.30
 */

import (VSC_LIB_PATH . 'domain/access/indexes');

class vscKeyIndexAccess extends vscSqlIndexAccessA {
	public function getType(vscIndexA $oIndex) {}
	public function getDefinition (vscIndexA $oIndex) {
		return	'INDEX ' . $oIndex->getName() . ' (' . $oIndex->getIndexComponents(). ')';
	}
}
