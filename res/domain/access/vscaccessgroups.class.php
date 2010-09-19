<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.09.19
 */
import ('domain/domain');

class vscAccessGroups extends vscObject {
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
	
	public function getDefinition ($aGroupBys) {
		$o = $this->getConnection();
		$sGroupBy = '';
		
		foreach ($aGroupBys as $aGroupBy) {
			$oField 	= $aGroupBy[0];
			$sDirection = $aGroupBy[1];
			
			$sGroupBy .= ($oField->hasAlias() ? $oField->getAlias() : $oField->getName()) . $sDirection;
		}
		return  ' ' .$o->_GROUP($sGroupBy);
	}
	
	abstract public function getType();
}
