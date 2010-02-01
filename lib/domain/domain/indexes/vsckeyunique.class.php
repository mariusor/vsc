<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */

class vscKeyUnique extends vscIndexA  {
	public function setName ($sName) {
		$this->name = $sName . '_unq';
	}
}