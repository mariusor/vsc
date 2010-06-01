<?php
/**
 * the query compiler/executer object
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @version 0.0.1
 */
import ('domain/access/sqldrivers');
import ('domain/access/fields');
import ('domain/access/indexes');
import ('domain/domain/indexes');

abstract class vscSqlAccessA extends vscObject implements vscSqlAccessI {
	/**
	 * @var vscSqlDriverA
	 */
	private $oConnection;

	public function __construct () {
		$this->setConnection(sqlFactory::connect(
			$this->getDatabaseType(),
			$this->getDatabaseHost(),
			$this->getDatabaseUser(),
			$this->getDatabasePassword()
		));

		$this->getConnection()->selectDatabase($this->getDatabaseName());
	}

	public function getDatabaseType() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabaseHost() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabaseUser() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabasePassword() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}
	public function getDatabaseName() {
		throw new vscExceptionDomain('Please implement ['. __METHOD__ . '] in a child class.');
	}

	/**
	 * @param vscSqlDriverA $oConnection
	 * @return void
	 */
	public function setConnection (vscSqlDriverA $oConnection) {
		$this->oConnection = $oConnection;
	}

	/**
	 * @return vscSqlDriverA
	 */
	public function getConnection () {
		if (!self::isValidConnection($this->oConnection))
			throw new vscInvalidTypeException ('Could not establish a valid DB connection - current resource type [' . get_class ($this->oConnection) . ']');
		return $this->oConnection;
	}

	static public function isValidConnection ($oConnection) {
		if ($oConnection instanceof vscSqlDriverA) {
			return sqlFactory::validType ($oConnection->getType());
		} else {
			return false;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#insert()
	 */
	public function insert (vscDomainObjectA $oDomainObject) {
		return $this->getConnection()->query($this->outputInsertSql($oDomainObject));
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#update()
	 */
	public function update (vscDomainObjectA $oDomainObject) {
		return $this->getConnection()->query($this->outputUpdateSql($oDomainObject));
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#delete()
	 */
	public function delete (vscDomainObjectA $oDomainObject) {
		return $this->getConnection()->query($this->outputDeleteSql($oDomainObject));
	}
}
