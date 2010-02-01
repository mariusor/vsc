<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */
class vscFieldVarChar extends vscFieldA {
	const TYPE = 'varchar';
	protected  $maxLength = 255;
	protected  $encoding = 'UTF-8';

	public function isVarChar (vscFieldA $oField) {
		return ($oField instanceof self);
	}

	public function getType () {
		return self::TYPE;
	}

	protected function escape () {
		// need a mechanism based on the connection type
		// TODO
		return $this->value;
	}

	public function getEncoding () {
		return $this->encoding;
	}

	public function setEncoding ($sEncoding) {
		$this->encoding = $sEncoding;
	}

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	$this->getType() .
				($this->getMaxLength() ? '(' . $this->getMaxLength() . ')' : '') .
				($this->getIsNullable() ? ' NULL' : ' NOT NULL');
	}
}