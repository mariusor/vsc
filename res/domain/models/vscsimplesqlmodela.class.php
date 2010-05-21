<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.03
 */

import ('domain/exceptions');
import ('domain/domain');
import ('domain/models');

abstract class vscSimpleSqlModelA extends vscModelA implements vscDomainObjectI {
	private $oConnection;

	final public function __construct () {
		$this->oConnection = sqlFactory::connect(
			$this->getDatabaseType(),
			$this->getDatabaseHost(),
			$this->getDatabaseUser(),
			$this->getDatabasePassword()
		);

		$this->oConnection->selectDatabase($this->getDatabaseName());

		parent::__construct();
	}

	public function __get ($sVarName) {
		try {
			return $this->getDomainObject()->__get($sVarName);
		} catch (Exception $e) {
			return parent::__get($sVarName);
		}
	}

	public function __set ($sVarName, $sValue) {
		try {
			return $this->getDomainObject()->$sVarName = $sValue;
		} catch (Exception $e) {
			return parent::__set($sVarName, $sValue);
		}
	}

	public function __call ($sMethodName, $aParameters) {
		$i = preg_match ('/(set|get)(.*)/i', $sMethodName, $found );
		if ($i) {
			$sMethod	= $found[1];
			$sProperty 	= $found[2];

			$sProperty[0] = strtolower ($sProperty[0]); // lowering the first letter

			$oProperty = $this->getDomainObject()->__get($sProperty);
		} else {
			$sMethod = $sMethodName;
		}

		if ( $sMethod == 'set' && vscFieldA::isValid($oProperty)) {
			// check for aFields with $found[1] sTableName
			$oProperty->setValue($aParameters[0]);
			return true;
		} else if ( $sMethod == 'get' ) {
			return $oProperty;
		} else {
			return $this->getDomainObject()->$sMethod ($aParameters[0]);
		}
		return parent::__call($sMethod, $aParameters);
	}

	public function getConnection () {
		return $this->oConnection;
	}

	public function __init() {}

	protected function buildObject() {
		$this->getDomainObject()->buildObject();
	}

	abstract public function getDatabaseType();
	abstract public function getDatabaseHost();
	abstract public function getDatabaseUser();
	abstract public function getDatabasePassword();
	abstract public function getDatabaseName();

	public function getDomainObject() {}

	public function getTableName() {}

	/**
	 * @param vscFieldA[] $aFields
	 * @param string $sAlias
	 * @return void
	 */
	public function addFields ($aFields, $sAlias) {}

	/**
	 * @param array $aIncField
	 * @return void
	 */
	public function addField ($aIncField) {}

	/**
	 * @return vscFieldA[]
	 */
	public function getFields () {
		$aReturnArray = array();
		foreach ($this->getDomainObject() as $oDomain) {
			$aReturnArray = array_merge ($aReturnArray, $oDomain->getFields());
		}

		return $aReturnArray;
	}

	protected function getPropertyNames ($bAll = false) {
		return $this->getFieldNames();
	}

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getFieldNames ($bWithAlias = false) {}

	public function addIndex (vscIndexA $oIndex) {}

	public function getIndexes ($bWithPrimaryKey = false) {}

	public function setConnection (vscSqlDriverA $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function loadByFilter ($aFieldsArray) { // this shold be moved to the composite model
		$aRet = array();
		$this->getDomainObject()->fromArray ($aFieldsArray);

		$a = new vscSimpleSqlAccess();
		$a->setConnection($this->getConnection());

		$this->getConnection()->query($a->outputSelectSql($this->getDomainObject()));

		foreach ($this->getConnection()->getArray() as $aValues) {
			$aObj 	= $this->getDomainObject();
			$aObj->fromArray($aValues);
			$aRet[] = $aObj;
		}

		return $aRet;
	}

	/**
	 *
	 * This has the only advantage over loadByFilter to ensure that the result returns a single entry
	 * @param array $aFieldsArray
	 * @throws vscExceptionDomain
	 * @returns vscDomainObjectA
	 */
	public function getByUniqueIndex ($aFieldsArray) {
		$bValid = false;
		$aFieldNames = array_keys($aFieldsArray);

		// tries to find a unique index of the entity which has values and selects an entry based on it
		// it will find at least the primary key
		$aIndexes = $this->getDomainObject()->getIndexes(true);
		/* @var $oIndex vscKeyUnique */
		foreach ($aIndexes as $oIndex) {
			if ($oIndex->getType() & vscIndexType::UNIQUE == vscIndexType::UNIQUE) {
				$aIndexFields 		= $oIndex->getFields();
				$aIndexFieldNames	= array_keys($aIndexFields);

				// setting the value of each field of the index
				if ($aIndexFieldNames == $aFieldNames) {
					foreach ($aIndexFields as $sFieldName => $oField) {
						$oField->setValue($aFieldsArray[$sFieldName]);
					}
					$bValid = true;
				}
			}
		}

		if ($bValid) {
			$a = new vscSimpleSqlAccess();
			$a->setConnection($this->getConnection());
			$sSql = $a->outputSelectSql($this->getDomainObject());

			$this->getConnection()->query($sSql);
			return $this->getDomainObject()->fromArray($this->getConnection()->getAssoc());
		} else {
			throw new vscExceptionDomain('None of the object unique indexes has all the neccessary values to get an unique instance.');
		}
	}

	public function getByPrimaryKey () {
		$a = new vscSimpleSqlAccess();
		$a->setConnection($this->getConnection());

		if ($this->getDomainObject()->hasPrimaryKey()) {
			$this->getDomainObject();
		}

		$this->getConnection()->query($a->outputSelectSql($this->getDomainObject()));

		return $this->getDomainObject()->fromArray($this->getConnection()->getAssoc());
	}
}

