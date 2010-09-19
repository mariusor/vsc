<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.09.19
 */
import ('domain/domain');

class vscAccessOrders extends vscObject {
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
	
	public function getDefinition ($aOrderBys) {
		$o = $this->getConnection();
		$sOrderBy = '';
		
		foreach ($aOrderBys as $aOrderBy) {
			$oField = $aOrderBy[0];
			$sDirection = $aOrderBy[1];
			
			$sOrderBy .= ($oField->hasAlias() ? $oField->getAlias() : $oField->getName()) . $sDirection;
		}
		return  ' ' .$o->_ORDER($sOrderBy);
	}
	
	abstract public function getType();
}
