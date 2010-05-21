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
				$mValue		=  $this->getConnection()->escape($oField->getValue());
				if (is_string($mValue)) {
					// this should be moved to the sql driver
					$sCondition = $this->getConnection()->STRING_OPEN_QUOTE . $mValue . $this->getConnection()->STRING_CLOSE_QUOTE;
				} elseif (is_numeric($mValue) || is_null($mValue)) {
					$sCondition = $mValue;
				}
				$aWheres[]	= $oDomainObject->getTableAlias() . '.' . $oField->getName() . ' = ' . $sCondition;
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

	/**
	 * Outputs the SQL necessary for creating the table
	 * @return string
	 */
	public function outputCreateTableSQL (vscDomainObjectI $oInc) {
		$sRet = $this->getConnection()->_CREATE ($oInc->getTableName()) . "\n";
		$sRet .= ' ( ' . "\n";

		/* @var $oColumn vscFieldA */
		foreach ($oInc->getFields () as $oColumn) {
			$sRet .= "\t" . $oColumn->getName() . ' ' . $oColumn->getDefinition() ;
			$sRet .= ', ' . "\n";
		}

		$aIndexes = $oInc->getIndexes(true);
		if (is_array ($aIndexes) && !empty($aIndexes)) {
			foreach ($aIndexes as $oIndex) {
				if (vscIndexA::isValid($oIndex)) {
				// this needs to be replaced with connection functionality : something like getConstraint (type, columns)
					$sRet .=  "\t" . $oIndex->getDefinition() . ", \n"; //getType() . ' KEY ' . $oIndex->getName() . '  (' . $oIndex->getIndexComponents(). '), ' . "\n";
				}
			}
		}

		$sRet = substr( $sRet, 0, -3 );

		$sRet.= "\n" . ' ) ';

		if ($this->oConnection->getType() == sqlFactory::mysql) {
			$sRet.= ' ENGINE ' . $this->getConnection()->getEngine();
		}

		return $sRet;
	}

}
