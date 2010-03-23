<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */

class vscKeyUnique extends vscKeyIndex  {
	public function setName ($sName) {
		$this->name = $sName . '_unq';
	}

	public function getType() {
		return 'INDEX';
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	'UNIQUE INDEX ' . $this->getName() . ' (' . $this->getIndexComponents(). ')';
	}
}