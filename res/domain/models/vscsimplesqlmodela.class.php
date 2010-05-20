<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.03
 */

import ('domain/domain');
import ('domain/access');
import ('domain/models');
import ('domain/access/sqldrivers');

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
			return $this->getDomainObject()->__set($sVarName, $sValue);
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
		}

		$oProperty = $this->getDomainObject()->__get($sProperty);

		if ( $sMethod == 'set' && vscFieldA::isValid($oProperty)) {
			// check for aFields with $found[1] sTableName
			$oProperty->setValue($aParameters[0]);
			return true;
		} else if ( $sMethod == 'get' ) {
			return $oProperty;
		}

		return parent::__call($sMethodName, $aParameters);
	}

	public function getConnection () {
		return $this->oConnection;
	}

	public function __init(){
	}

//	abstract protected function buildObject();

	abstract public function getDatabaseType();
	abstract public function getDatabaseHost();
	abstract public function getDatabaseUser();
	abstract public function getDatabasePassword();
	abstract public function getDatabaseName();

//	abstract public function getDomainObject();

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

	public function getById ($iId) {
		$a = new vscSimpleSqlAccess();
		$a->setConnection($this->getConnection());

		$this->setId($iId);

		$this->getConnection()->query($a->outputSelectSql($this->getDomainObject()));

		return $this->getDomainObject()->fromArray($this->getConnection()->getAssoc());
	}
}
