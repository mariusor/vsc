<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.05.20
 */

import ('domain/domain');
import ('domain/models');
import ('domain/connections');

abstract class vscCompositeSqlModelA extends vscSimpleSqlModelA implements vscCompositeDomainObjectI {
	private $oConnection;

	public function __construct () {
		parent::__construct();
		$this->__init();
	}

	public function getDomainObjects () {
		$oRef = new ReflectionObject($this);
		$aRet = array();
		$aProperties = $oRef->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PRIVATE);
		/* @var $oProperty ReflectionProperty */
		foreach ($aProperties as $oProperty) {
			if (!$oProperty->isPrivate()) {
				$oValue = $oProperty->getValue($this);
			} else {
				$oProperty->setAccessible(true);
				$oValue = $oProperty->getValue($this);
				$oProperty->setAccessible(false);
			}
			if (vscDomainObjectA::isValid($oValue)) {
				$aRet[$oProperty->getName()] = $oValue;
			}
		}
		return $aRet;
	}

	public function __get ($sName) {
		$aDomainObjects =  $this->getDomainObjects();
		return $aDomainObjects[$sName];
	}

	public function getDomainObjectRelations () {}

	public function setConnection (vscConnectionA $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function getConnection () {
		return $this->oConnection;
	}

	public function __init(){
		$this->oConnection = vscConnectionFactory::connect(
			$this->getDatabaseType(),
			$this->getDatabaseHost(),
			$this->getDatabaseUser(),
			$this->getDatabasePassword()
		);

		$this->oConnection->selectDatabase($this->getDatabaseName());
	}

	//	abstract protected function buildObject();
	/*
	abstract public function getDatabaseType();
	abstract public function getDatabaseHost();
	abstract public function getDatabaseUser();
	abstract public function getDatabasePassword();
	abstract public function getDatabaseName();
	*/

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

//	public function getTableName() {}

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
	public function getFieldNames($bWithAlias = false) {
		$aRet = array();
		/* @var $oDomainObject vscDomainObjectA */
		foreach ($this->getDomainObjects() as $oDomainObject) {
			$aRet = array_merge ($aRet, $oDomainObject->getFieldNames(true));
		}

		return $aRet;
	}

	public function addIndex (vscIndexA $oIndex) {}

	public function getIndexes ($bWithPrimaryKey = false) {}

	public function getById ($iId) {
		$a = new vscSimpleSqlAccess();
		$a->setConnection($this->getConnection());

		d ($a->outputSelectSql($this->getDomainObjects()));
	}

	public function getForeignKeys () {}
}

