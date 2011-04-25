<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.09.19
 */
import ('domain/domain');

class vscAccessOrders extends vscObject {
	private $oConnection;
	/**
	 * @param vscConnectionA $oConnection
	 * @return null
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
