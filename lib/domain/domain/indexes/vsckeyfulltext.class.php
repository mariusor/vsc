<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */

class vscKeyFullText extends vscKeyIndex  {
	public function setName ($sName) {
		$this->name = $sName . '_tx';
	}

	public function getType() {
		return 'INDEX';
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	'FULLTEXT INDEX ' . $this->getName() . ' (' . $this->getIndexComponents(). ')';
	}
}
