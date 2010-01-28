<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.13
 */
class fooFieldEnum extends fooFieldA {
	const TYPE = 'enum';
	protected $values = array();

	public function isVarChar (fooFieldA $oField) {
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