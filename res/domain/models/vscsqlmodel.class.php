<?php
/**
 * @package vsc_domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.01.03
 */

import ('domain/models');
class vscSqlModel extends vscEmptyModel {
	private $oConnection;

	public function setConnection (vscSqlDriverA $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function getConnection () {
		return $this->oConnection;
	}
//
//	public function __init(){
//		import ('domain/access/sqldrivers');
//		$this->dbConnection = sqlFactory::connect('mysqli', 'localhost', 'root', 'ASD');
//		$this->dbConnection->selectDatabase('b');
//	}
}