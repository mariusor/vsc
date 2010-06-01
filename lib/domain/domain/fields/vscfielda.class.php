<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.03.29
 */
abstract class vscFieldA implements vscFieldI {
	protected  $name;
	protected  $value;
	protected  $default = null;
	protected  $parent;
	protected  $modifier = null;
    protected  $sAlias;

	protected  $nullable = true;
	protected  $maxLength;

	/**
	 * @param mixed $oField
	 * @return bool
	 */
	final static public function isValid ($oField) {
		return ($oField instanceof self);
	}

	public function __construct ($incName) {
		$this->name		= $incName;
	}

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

	public function hasValue() {
		return ($this->value !== null && $this->value != $this->default);
	}

	public function setValue ($value) {
		$this->value = $value;
	}

	public function getValue () {
		return $this->value;
	}

	public function setDefaultValue ($value) {
		$this->default = $value;
	}

	public function getDefaultValue () {
		return $this->default;
	}

	public function hasDefaultValue () {
		return ($this->default !== null || ($this->getIsNullable() && $this->default === null));
	}

	public function setGroup ($true = true) {
		$this->group = (bool)$true;
	}

	public function setOrder ($asc = true) {
		$this->order = (bool)$asc;
	}

	public function hasAlias () {
        return !empty($this->sAlias);
    }

    public function setAlias ($sAlias) {
        $this->sAlias = $sAlias;
    }

    public function getAlias () {
        return $this->sAlias;
    }

    public function setParent(vscDomainObjectA $oDomainObject) {
    	$this->parent = $oDomainObject;
    }

    public function getTableAlias() {
    	return  $this->parent->hasTableAlias() ? $this->parent->getTableAlias() : $this->parent->getTableName();
    }
}
