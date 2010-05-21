<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
import (VSC_LIB_PATH . 'domain/domain/fields');

class vscFieldInteger extends vscFieldA {
	const TYPE = 'integer';
	protected  $maxLength = 11;
	protected  $autoIncrement = false;

	public function isInt (vscFieldA $oField) {
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