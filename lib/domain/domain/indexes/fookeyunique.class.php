<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.04.27
 */

class fooKeyUnique extends fooIndexA  {
	public function setName ($sName) {
		$this->name = $sName . '_unq';
	}
}