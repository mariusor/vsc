<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.04.25
 */

abstract class vscCompositeDomainObjectA extends vscObject implements vscCompositeDomainObjectI {
	private $aForeignKeys = array();

	abstract public function buildObject();

	public function __construct () {
		$this->buildObject();
	}

	public function getDomainObjects () {
		$oRef = new ReflectionObject($this);
		$aProperties = $oRef->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PRIVATE);
		$aRet = array();

		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			if (!$oProperty->isPrivate()) {
				$oValue = $oProperty->getValue($this);
			} else {
				$oProperty->setAccessible(true);
				$oValue = $oProperty->getValue($this);
			}
			if (vscDomainObjectA::isValid($oValue)) {
				$aRet[$oProperty->getName()] = $oValue;
			}
		}

		return $aRet;
	}

	/**
	 * Returns the names of the tables
	 * @param bool $bWithAlias
	 */
	public function getDomainObjectNames ($bWithAlias = false) {
		$aDomainObjects = $this->getDomainObjects();
		if ($bWithAlias === false) {
			return array_keys ($aDomainObjects);
		} else {
			$aRet = array();
			/* @var $oDomainObject vscDomainObjectA */
			foreach ($aDomainObjects as $oDomainObject) {
				if ($oDomainObject->hasTableAlias()) {
					$aRet[] = $oDomainObject->getTableAlias();
				} else {
					$aRet[] = $oDomainObject->getTableName();
				}

			}
			return $aRet;
		}
	}

	public function getIndexes($bWithPrimaryKey = false) {
		$aKeys = array();
		$aDomainObjects = $this->getDomainObjects();

		/* @var $oDomainObject vscDomainObjectA */
		foreach ($aDomainObjects as $oDomainObject) {
			$aKeys[$oDomainObject->getTableAlias()] = $oDomainObject->getIndexes($bWithPrimaryKey);
		}

		return $aKeys;
	}

	public function getFields () {
		$aFields = array();
		$aDomainObjects = $this->getDomainObjects();

		/* @var $oDomainObject vscDomainObjectA */
		foreach ($aDomainObjects as $oDomainObject) {
			$aFields = array_merge ($aFields, $oDomainObject->getFields());
		}

		return $aFields;
	}

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getFieldNames ($bWithAlias = false) {
		$aFields = array();
		$aDomainObjects = $this->getDomainObjects();

		/* @var $oDomainObject vscDomainObjectA */
		foreach ($aDomainObjects as $oDomainObject) {
			$aFields[$oDomainObject->getTableAlias()] = $oDomainObject->getFieldNames($bWithAlias);
		}

		return $aFields;
	}

	public function addDomainObject (vscDomainObjectA $oIncDomainObject) {
		$aDomainObjects = $this->getDomainObjects();
		if (!key_exists($sName, $aDomainObjects)) {
			$oIncDomainObject->setParent($this);
			$oRef = new ReflectionProperty($this, $oIncDomainObject->getTableName());
			$oRef->setValue($object, $oIncDomainObject);

			$oRef->setAccessible(false);
		}
	}

	public function addForeignKey ($oRightField, $oLeftField) {
		if (!vscFieldA::isValid($oRightField) || !vscFieldA::isValid($oLeftField))
			throw new vscExceptionInvalidType('Objects [' . get_class($oRightField) . '] and [' .get_class($oLeftField) .' ] do not have the proper types, expected [vscFieldA],[vscFieldA]' );
		$iKey = count ($this->aForeignKeys);
		if (!$oRightField->getParent()->hasTableAlias())
			$oRightField->getParent()->setTableAlias('c'.$iKey);
		if (!$oLeftField->getParent()->hasTableAlias())
			$oLeftField->getParent()->setTableAlias('c'.($iKey+1));
		$this->aForeignKeys[] = array ($oRightField, $oLeftField);
	}

	public function getForeignKeys (){
		return $this->aForeignKeys;
	}


}