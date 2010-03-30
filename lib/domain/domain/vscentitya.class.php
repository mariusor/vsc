<?php
/**
 * The abstract object entity - it represents an entry in the database.
 * It can be composed from more Entity Objects using reflection
 *
 * @package domain
 * @subpackage domain
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.02.26
 */
import (VSC_LIB_PATH . 'domain/domain/fields');
import (VSC_LIB_PATH . 'domain/domain/indexes');

abstract class vscEntityA extends vscNull {
	protected 	$sTableName;
	private 	$sTableAlias;
	private 	$oPk;
	private		$aFields = array ();
	private 	$aIndexes = array ();

	final public function __construct () {
		$this->buildObject();
	}

	abstract protected function buildObject();

	public function __call ($sMethodName, $aParameters) {
//		d ($sMethodName, $aParameters);
		$i = preg_match ('/(set|get)(.*)/i', $sMethodName, $found );
		if ($i) {
			$sMethod	= $found[1];
			$sProperty 	= $found[2];

			$sProperty[0] = strtolower ($sProperty[0]); // lowering the first letter
		}

		if ( $sMethod == 'set' ) {
			// check for aFields with $found[1] sTableName
			$this->$sProperty->setValue($aParameters[0]);
			return true;
		} else if ( $sMethod == 'get' ) {
			return $this->$sProperty->getValue();
		}

		return parent::__call($sMethodName, $aParameters);
	}

	public function __get ($sPropertyName) {
		return $this->aFields[$sPropertyName];
	}

	public function __set ($sPropertyName, $mValue) {
		if (vscFieldA::isValid ($mValue)) {
			$this->aFields[$sPropertyName] = $mValue;
		} else {
			$this->aFields[$sPropertyName]->setValue($mValue);
		}
	}

	/**
	 * @param string $sAlias
	 * @return void
	 */
	public function setTableAlias ($sAlias) {
		$this->sTableAlias = $sAlias;
	}

	/**
	 * @return string
	 */
	public function getTableAlias () {
		return $this->sTableAlias;
	}

	/**
	 * @param string $sName
	 * @return void
	 */
	protected function setTableName ($sName) {
		$this->sTableName = $sName;
	}

	public function getTableName () {
		return $this->sTableName;
	}

	/**
	 * @param vscFieldA $oIndex
	 * @return void
	 */
	public function setPrimaryKey () {
		$this->oPk = new vscKeyPrimary (func_get_args());
	}

	public function getPrimaryKey () {
		return $this->oPk;
	}

	/**
	 * @param vscFieldA[] $aFields
	 * @param string $sAlias
	 * @return void
	 */
	private function addFields ($aFields, $sAlias) {
		foreach ($aFields as $sFieldName => $oField) {
			$this->addField (array ($sAlias . '.' . $sFieldName => $oField));
		}
	}

	/**
	 * @param array $aIncField
	 * @return void
	 */
	private function addField ($aIncField) {
		$sKey = key($aIncField);
		$this->aFields [$sKey] = $aIncField[$sKey];
	}

	/**
	 * @return vscFieldA[]
	 */
	public function getFields () {
		return $this->aFields;
	}

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getFieldNames ($bWithAlias = false) {
		$aRet = array_keys($this->aFields);
		if ($bWithAlias) {
			foreach ($aRet as $key => $sFieldName) {
				$aRet[$key] = $this->getTableAlias() . '.' . $sFieldName;
			}
		}
		return $aRet;
	}

	public function addIndex (vscIndexA $oIndex) {
		$this->aIndexes[] = $oIndex;
	}

	public function getIndexes ($bWithPrimaryKey = false) {
		$aIndexes = array ();
		if ($bWithPrimaryKey)
			$aIndexes[] = $this->getPrimaryKey();

		$aIndexes = array_merge ($aIndexes, $this->aIndexes);
		return $aIndexes;
	}

	/**
	 * returns an array of key=>value for all properties of the current object
	 * @return mixed[]
	 */
	public function toArray () {
		$aRet = array();

		foreach ($this->getFields() as $sFieldName => $oField) {
			$aRet[$sFieldName]	= $oField->getValue();
		}

		return $aRet;
	}

	/**
	 * Receives an array of keys=> values and constructs an entity based on
	 * the existing ones.
	 * Returns:
	 * 1 if all array keys existed as properties of the object
	 * 0 if one of the keys didn't exist as a property of the object
	 * 2 if there were properties which didn't have a corresponding key=>value pair
	 * @param mixed[string] $aIncArray
	 * @return int
	 */
	public function fromArray ($aIncArray) {
		foreach ($aIncArray as $sFieldName => $mValue) {
			try {
				$this->aFields[$sFieldName]->setValue ($mValue);
			} catch (Exception $e) {
				// dunno what might be thrown here
				d ($e);
				return 0;
			}
		}
		return 1;
	}

	/**
	 *
	 * @param vscEntityA $oChild
	 * @return bool
	 */
	public function loadChild (vscEntityA $oChild) {}

	/**
	 * @todo Finish IT !!
	 * @param vscEntityA $oChild
	 * @return bool
	 */
	public function join (vscEntityA $oObject) {
		$this->addFields ($oObject->getFields (), $oObject->getTableName());

		return $this;
	}
}
