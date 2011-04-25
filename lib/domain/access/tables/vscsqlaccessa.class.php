<?php
/**
 * the query compiler/executer object
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @version 0.0.1
 */
import ('domain/connections');
import ('domain/access/fields');
import ('domain/access/indexes');
import ('domain/domain/indexes');

abstract class vscSqlAccessA extends vscObject implements vscSqlAccessI {
	/**
	 * @var vscConnectionA
	 */
	private $oConnection;

	public function __construct () {
		$this->setConnection(vscConnectionFactory::connect(
			$this->getDatabaseType(),
			$this->getDatabaseHost(),
			$this->getDatabaseUser(),
			$this->getDatabasePassword()
		));

		$this->getConnection()->selectDatabase($this->getDatabaseName());
	}

	abstract public function getDatabaseType();
	abstract public function getDatabaseHost();
	abstract public function getDatabaseUser();
	abstract public function getDatabasePassword();
	abstract public function getDatabaseName();

	/**
	 * @param vscConnectionA $oConnection
	 * @return void
	 */
	public function setConnection (vscConnectionA $oConnection) {
		$this->oConnection = $oConnection;
	}

	/**
	 * @return vscConnectionA
	 */
	public function getConnection () {
		if (!self::isValidConnection($this->oConnection))
			throw new vscInvalidTypeException ('Could not establish a valid DB connection - current resource type [' . get_class ($this->oConnection) . ']');
		return $this->oConnection;
	}

	static public function isValidConnection ($oConnection) {
		if ($oConnection instanceof vscConnectionA) {
			return vscConnectionFactory::validType ($oConnection->getType());
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
