<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */

class vscKeyFullText implements vscIndexA  {
	public function setName ($sName) {
		$this->name = $sName . '_tx';
	}
}
