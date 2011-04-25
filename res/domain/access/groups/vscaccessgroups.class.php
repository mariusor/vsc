<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.09.19
 */
import ('domain/domain');

class vscAccessGroups extends vscObject {
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
