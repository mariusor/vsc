<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */
import (VSC_LIB_PATH . 'domain/domain/indexes');

class vscKeyFullText extends vscKeyIndex  {
	public function setName ($sName) {
		$this->name = $sName . '_tx';
	}

	public function getType() {
		return vscIndexType::UNIQUE;
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	'FULLTEXT INDEX ' . $this->getName() . ' (' . $this->getIndexComponents(). ')';
	}
}
