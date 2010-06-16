<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.06.02
 */
abstract class vscSqlJoinAccessA extends vscObject {
	private $oConnection;
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
		return $this->oConnection;
	}


	public function getDefinition (vscJoinA $oJoin) {
		$o = $this->getConnection();
		$oTable = $oJoin->getRight()->getParent();
		return  ' ' . $o->_JOIN($this->getType()) . $oTable->getTableName() . $o->_AS ($oTable->getTableAlias());
	}

	abstract public function getType();
}