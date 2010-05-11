<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.03
 */

import ('domain/domain');
import ('domain/models');
import ('domain/access/sqldrivers');

abstract class vscSqlModelA extends vscModelA implements vscDomainObjectI {
	private $oConnection;

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
		foreach ($this->getDomainObjects() as $oDomain) {
			$aReturnArray = array_merge ($aReturnArray, $oDomain->getFields());
		}

		return $aReturnArray;
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

	public function getConnection () {
		return $this->oConnection;
	}

	public function __init(){
		$this->dbConnection = sqlFactory::connect(
			$this->getDatabaseType(),
			$this->getDatabaseHost(),
			$this->getDatabaseUser(),
			$this->getDatabasePassword()
		);

		$this->dbConnection->selectDatabase($this->getDatabaseName());
	}

	abstract public function getDatabaseType();
	abstract public function getDatabaseHost();
	abstract public function getDatabaseUser();
	abstract public function getDatabasePassword();
	abstract public function getDatabaseName();

    public function getDomainObjects () {
    	$aRet = array();
        $oRef = new ReflectionClass($this);
        $aProperties = $oRef->getProperties(ReflectionProperty::IS_PUBLIC);

        /* $oProperty ReflectionProperty */
        foreach ($aProperties as $oProperty) {
            if (vscDomainObjectA::isValid ($oProperty->getValue($this))) {
                $aRet[$oProperty->getName()] = $oProperty->getValue($this);
            }
        }
        return $aRet;
    }

    public function addJoin (vscDomainObjectA $oRightObj, vscFieldA $oRightField, vscDomainObjectA $oLeftObj, vscFieldA $oLeftField) {
		$oRightObj->setTableAlias('t1');
		$oLeftObj->setTableAlias('t2');
    }

	/**
	 *
	 * @param vscDomainObjectA $oChild
	 * @return bool
	 */
	public function loadChild (vscDomainObjectA $oChild) {}

	/**
	 * @todo Finish IT !!
	 * @param vscDomainObjectA $oChild
	 * @return bool
	 */
	public function join (vscDomainObjectA $oObject) {
		$this->addFields ($oObject->getFields (), $oObject->getTableName());

		return $this;
	}
}

