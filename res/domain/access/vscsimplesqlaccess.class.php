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
				$aSelectFields[]	= $this->getConnection()->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $this->getConnection()->FIELD_CLOSE_QUOTE .
									'.' . $this->getConnection()->FIELD_OPEN_QUOTE . $oField->getName() . $this->getConnection()->FIELD_CLOSE_QUOTE .
									($oField->hasAlias() ? $this->getConnection()->_AS($this->getConnection()->FIELD_OPEN_QUOTE . $oField->getAlias(). $this->getConnection()->FIELD_CLOSE_QUOTE) : '');
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
			if (is_numeric($mValue) || is_null($mValue)) {
					$sCondition = $mValue;
				} elseif (is_string($mValue)) {
					// this should be moved to the sql driver
					$sCondition = $this->getConnection()->STRING_OPEN_QUOTE . $mValue . $this->getConnection()->STRING_CLOSE_QUOTE;
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

//		if (!$oDomainObject->getTableAlias()) {
//			$oDomainObject->setTableAlias ('filter');
//		}

		$sRet = $this->getConnection()->_SELECT ($this->getFieldsForSelect($oDomainObject)) .
				$this->getConnection()->_FROM($oDomainObject->getTableName()) . $oDomainObject->getTableAlias() ."\n";

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

	public function loadByFilter (vscDomainObjectA $oDomainObject, $aFieldsArray = array()) { // this shold be moved to the composite model
		$aRet = array();
		$oDomainObject->fromArray ($aFieldsArray);
		$sType = get_class($oDomainObject);

		$this->getConnection()->query($this->outputSelectSql($oDomainObject));

		foreach ($this->getConnection()->getArray() as $aValues) {
			$oRet = new $sType();
			$oRet->fromArray ($aValues);

			// theoretically the primary key is unique enough
			// the conversion to string calls vscIndexA::__toString
			$sKey = (string)$oRet->getPrimaryKey();
			if ($sKey === '') {
				$sKey = count ($aRet);
			}

			$aRet[] = $oRet;
		}

		return $aRet;
	}

	/**
	 *
	 * This has the only advantage over loadByFilter to ensure that the result returns a single entry
	 * @param array $aFieldsArray
	 * @throws vscExceptionDomain
	 * @returns vscDomainObjectA
	 */
	public function getByUniqueIndex (vscDomainObjectA $oDomainObject, $aFieldsArray = array()) {
		$bValid = false;
		$aFieldNames = array_keys($aFieldsArray);

		// tries to find a unique index of the entity which has values and selects an entry based on it
		// it will find at least the primary key
		$aIndexes = $oDomainObject->getIndexes(true);
		/* @var $oIndex vscKeyUnique */
		foreach ($aIndexes as $oIndex) {
			if ($oIndex->getType() & vscIndexType::UNIQUE == vscIndexType::UNIQUE) {
				$aIndexFields 		= $oIndex->getFields();
				$aIndexFieldNames	= array_keys($aIndexFields);

				// setting the value of each field of the index
				if ($aIndexFieldNames == $aFieldNames) {
					foreach ($aIndexFields as $sFieldName => $oField) {
						$oField->setValue($aFieldsArray[$sFieldName]);
					}
					$bValid = true;
				}
			}
		}

		if ($bValid) {
			$sSql = $this->outputSelectSql($this->getDomainObject());

			$this->getConnection()->query($sSql);
			return $oDomainObject->fromArray($this->getConnection()->getAssoc());
		} else {
			throw new vscExceptionDomain('None of the object unique indexes has all the neccessary values to get an unique instance.');
		}
	}

	public function getByPrimaryKey (vscDomainObjectA $oDomainObject) {
		if ($oDomainObject->hasPrimaryKey()) {
			$oDomainObject;
		}

		$this->getConnection()->query($this->outputSelectSql($this->getDomainObject()));

		return $oDomainObject->fromArray($this->getConnection()->getAssoc());
	}
}
