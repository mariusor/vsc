<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.01
 */
class vscSimpleSqlAccess extends vscSimpleSqlAccessA implements vscSqlAccessI {
	public function save ($oInc) {}

	public function create ($oInc) {}

	public function update ($oInc) {}

	public function delete ($oInc) {}

	public function getFieldsForSelect (vscDomainObjectI $oDomainObject) {
		$aSelectFields = array ();
		/* @var $oField vscFieldA */
		foreach ($oDomainObject->getFields() as $oField) {
			if (is_null($oField->getValue())) {
				$aSelectFields[] = $oDomainObject->getTableAlias() . '.' . $oField->getName();
			}
		}

		return implode(', ', $aSelectFields);
	}

	public function getDefaultWhereClauses (vscDomainObjectI $oDomainObject) {
		$aWheres = null;
		/* @var $oField vscFieldA */
		foreach ($oDomainObject->getFields() as $oField) {
			if (!is_null($oField->getValue())) {
				$aWheres[] = $oDomainObject->getTableAlias() . '.' . $oField->getName() . ' = ' . $this->getConnection()->escape($oField->getValue());
			}
		}

		if ( is_null ($aWheres) ) {
			$aWheres = array (1);
		}

		return implode($this->getConnection()->_AND(), $aWheres);
	}

	/**
	 * @TODO - next item on the agenda
	 * @param $oInc
	 * @return string
	 */
	public function outputSelectSql (vscDomainObjectI $oDomainObject) {
        $aWheres = array();

		if (!$oDomainObject->getTableAlias()) {
			$oDomainObject->setTableAlias ('filter');
		}

		$sRet = $this->getConnection()->_SELECT ($this->getFieldsForSelect($oDomainObject)) . $this->getConnection()->_FROM($oDomainObject->getTableName()) . $oDomainObject->getTableAlias() ."\n";
        $sRet .= $this->getConnection()->_WHERE($this->getDefaultWhereClauses($oDomainObject));
		return $sRet;
	}

}
