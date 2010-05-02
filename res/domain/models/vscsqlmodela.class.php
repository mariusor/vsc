<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.03
 */

import ('domain/models');
import ('domain/access/sqldrivers');

abstract class vscSqlModelA extends vscModelA {
	private $oConnection;

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
        $oRef = new ReflectionClass($this);
        $aProperties = $oRef->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($aProperties as $oProperty) {
            if (vscDomainObjectA::isValid ($oProperty)) {
                $aRet[$oProperty->getName()] = $oProperty->getValue($this);
            }
        }
        return $aRet;
    }

    public function addJoin (vscDomainObjectA $oRightObj, vscFieldA $oRightField, vscDomainObjectA $oLeftObj, vscFieldA $oLeftField) {

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

