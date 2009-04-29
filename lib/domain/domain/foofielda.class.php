<?php
/**
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
abstract class fooFieldA implements fooFieldI {
	protected  $name;
	protected  $value;
	protected  $parent;
	protected  $modifier = null;
	protected  $order = null;
	protected  $group = null;
	protected  $where = false;

	protected  $nullable = true;
	protected  $maxLength;

	/**
	 * @param mixed $oField
	 * @return bool
	 */
	static public function isValid ($oField) {
		return ($oField instanceof self);
	}

	public function __construct ($incName) {
		$this->name		= $incName;
	}

	public function __destruct () {}

	public function __toString () {
		return (string)$this->value;
	}

	/**
	 * @param bool $bIsNull
	 * @return void
	 */
	public function setIsNullable ($bIsNull) {
		$this->nullable = (bool)$bIsNull;
	}

	/**
	 * @return bool
	 */
	public function getIsNullable () {
		return $this->nullable;
	}

	public function setName($sName) {
		$this->name = $sName;
	}

	public function getName () {
		return $this->name;
	}

	public function setModifier ($sModifier) {
		$this->modifier = $sModifier;
	}

	public function setMaxLength($fLen) {
		$this->maxLength = $fLen;
	}

	public function getMaxLength() {
		return $this->maxLength;
	}

	public function setValue ($value) {
		$this->value = $value;
	}

	public function setGroup ($true = true) {
		$this->group = (bool)$true;
	}

	public function setOrder ($asc = true) {
		$this->order = (bool)$asc;
	}

	abstract protected function escape ();
}