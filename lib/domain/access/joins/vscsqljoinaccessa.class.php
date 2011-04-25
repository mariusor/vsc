<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.06.02
 */
abstract class vscSqlJoinAccessA extends vscObject {
	private $oConnection;
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
		return $this->oConnection;
	}


	public function getDefinition (vscJoinA $oJoin) {
		$o = $this->getConnection();
		$oTable = $oJoin->getRight()->getParent();
		return  ' ' . $o->_JOIN($this->getType()) . $oTable->getTableName() . $o->_AS ($oTable->getTableAlias());
	}

	abstract public function getType();
}