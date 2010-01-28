<?php
/**
 * @package domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */
class vscFieldDateTime extends vscFieldA {
	const TYPE = 'datetime';
	protected  $maxLength = null; // arbitrary chosen, > strlen(YYYY-MM-DD GG:II:SS)

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

	public function getDefinition () {
		// this is totally wrong for PostgreSQL
		return	$this->getType() .
				($this->getIsNullable() ? ' NULL' : ' NOT NULL');
	}
}