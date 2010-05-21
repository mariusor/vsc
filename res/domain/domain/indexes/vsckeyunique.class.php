<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */
import (VSC_LIB_PATH . 'domain/domain/indexes');

class vscKeyUnique extends vscKeyIndex  {
	public function setName ($sName) {
		$this->name = $sName . '_unq';
	}

	public function getType() {
		return vscIndexType::UNIQUE;
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	'UNIQUE INDEX ' . $this->getName() . ' (' . $this->getIndexComponents(). ')';
	}
}