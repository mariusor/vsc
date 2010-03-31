<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.13
 */
class vscFieldEnum extends vscFieldA {
	const TYPE = 'enum';
	protected $values = array();

	public function isVarChar (vscFieldA $oField) {
		return ($oField instanceof self);
	}

	public function getType () {
		return self::TYPE;
	}

	protected function escape () {
		return $this->value;
	}

	public function getDefinition () {
		return	$this->getType();
	}
}