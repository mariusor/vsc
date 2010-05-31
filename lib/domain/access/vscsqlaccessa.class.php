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

	final public function __construct () {
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

	public function getFieldAccess (vscFieldA $oField) {
		$oFieldAccess = null;
		switch ($oField->getType()) {
			case (vscFieldType::INTEGER):
			case ('integer'):
				$oFieldAccess = new vscFieldIntegerAccess();
				break;
			case (vscFieldType::TEXT):
			case ('varchar'):
			case ('text'):
				$oFieldAccess = new vscFieldTextAccess();
				break;
			case (vscFieldType::DATETIME):
			case ('datetime'):
				$oFieldAccess = new vscFieldDateTimeAccess();
				break;
			case (vscFieldType::ENUM):
			case ('enum'):
				$oFieldAccess = new vscFieldEnumAccess();
				break;
		}

		$oFieldAccess->setConnection($this->getConnection());

		return $oFieldAccess;
	}

	public function getIndexAccess (vscIndexA $oIndex) {
		$oIndexAccess = null;
		switch ($oIndex->getType()) {
			case (vscIndexType::PRIMARY):
				$oIndexAccess = new vscKeyPrimaryAccess();
				break;
			case (vscIndexType::FULLTEXT):
				$oIndexAccess = new vscKeyFullTextAccess();
				break;
			case (vscIndexType::INDEX):
				$oIndexAccess = new vscKeyIndexAccess();
				break;
			case (vscIndexType::UNIQUE):
				$oIndexAccess = new vscKeyUniqueAccess();
				break;
		}

		$oIndexAccess->setConnection($this->getConnection());

		return $oIndexAccess;
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
