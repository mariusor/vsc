<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.05.01
 */
class vscFieldText extends vscFieldA {
	protected  $maxLength = 255;
	protected  $encoding = 'UTF8';

	public function getType () {
		if ($this->getMaxLength() > 255 || is_null($this->getMaxLength()))
			return 'text';
		else
			return 'varchar';
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
				($this->getEncoding() ? ' CHARACTER SET ' . $this->getEncoding() : '') .
				($this->getIsNullable() ? ' NULL' : ' NOT NULL');
	}
}