<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */

class vscKeyFullText extends vscKeyIndex  {
	public function setName ($sName) {
		$this->name = $sName . '_tx';
	}

	public function getType() {
		return vscIndexType::UNIQUE;
	}
}
