<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
usingPackage ('models/foo');

class fooFieldInteger extends fooFieldA {
	const TYPE = 'integer';
	protected  $maxLength = 11;
	protected  $autoIncrement = false;

	public function isInt (fooFieldA $oField) {
		return ($oField instanceof self);
	}

	public function getType () {
		return self::TYPE;
	}

	protected function escape () {
		return (int) $this->value;
	}

	/**
	 * @param bool $bIsAutoIncrement
	 * @return void
	 */
	public function setAutoIncrement ($bIsAutoIncrement) {
		$this->autoIncrement = (bool)$bIsAutoIncrement;
	}

	public function getAutoIncrement () {
		return $this->autoIncrement;
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	$this->getType() .
				($this->getMaxLength() ? '(' . $this->getMaxLength() . ')' : '') .
				($this->getIsNullable() ? ' NULL' : ' NOT NULL') .
				($this->getAutoIncrement() ? ' AUTO_INCREMENT' : '');
	}
}