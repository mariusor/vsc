<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.01
 */
import ('domain/domain');
class vscSqlAccess extends vscSqlAccessA {

	public function getQuotedFieldList (vscDomainObjectI $oDomainObject, $bWithAlias = false, $bWithTableAlias = false) {
		$aRet = array ();
		$o = $this->getConnection();

		foreach ($oDomainObject->getFields() as $oField) {
			$sField = '';
			if ($bWithTableAlias && $oDomainObject->getTableAlias()) {
				$sField = $o->FIELD_OPEN_QUOTE .  $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE . '.';
			}

			$sField .= $o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE . ($bWithAlias && $oField->getAlias() ? $o->_AS() . $o->FIELD_OPEN_QUOTE . $oField->getAlias() . $o->FIELD_CLOSE_QUOTE : '');

			$aRet[] = $sField;
		}

		return $aRet;
	}

	public function getFieldValues (vscDomainObjectI $oDomainObject) {
		$aRet = array ();
		foreach ($oDomainObject->getFields() as $oField) {
			try {
				$aRet[$oField->getName()] = $this->getFieldAccess($oField)->escapeValue($oField);
			} catch (vscExceptionConstraint $e) {
				//
			}
		}
		return $aRet;
	}

	/**
	 *
	 * Enter description here ...
	 * @param vscDomainObjectI $oDomainObject
	 * @param array $aValues array (0 => array (// usable with fromArray), ... )
	 */
	public function outputInsertSql (vscDomainObjectI $oDomainObject, $aValuesGroup = null) {
		$sSql = '';
		$aWheres = array();
		$aUpdateFields = array();

		$o = $this->getConnection();
		$sSql = $o->_INSERT($o->FIELD_OPEN_QUOTE . $oDomainObject->getTableName() . $o->FIELD_CLOSE_QUOTE);

		$aFields = $oDomainObject->toArray();
		$aValues = array_keys ($aFields);

		$sSql .= ' ( '.implode (', ', $this->getQuotedFieldList ($oDomainObject)) . ' )';

		foreach ($oDomainObject->getFields() as $oField) {
			if ($oField->hasValue()) {
				$aInsertFields[] = $o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE . ' = ' . $this->getQuotedValue($oField->getValue());
			}
		}

		$aValueArray = array();
		if (is_array($aValuesGroup)) {
			$aInitialValues = $oDomainObject->toArray();
			foreach ($aValuesGroup as $aValues) {
				$oDomainObject->reset();
				$oDomainObject->fromArray ($aValues);
				$aValueArray[] = implode (', ',  $this->getFieldValues($oDomainObject));
			}
			$sValueString = '( '. implode (' ), ( ', $aValueArray) . ' )';
			$oDomainObject->fromArray ($aInitialValues);
		} else {
			$sValueString = '( ' . implode (', ', $this->getFieldValues($oDomainObject)) . ' )';
		}

		$sSql .= $o->_VALUES($sValueString);

		return $sSql;
	}

	/**
	 * this is not exactly perfect, as it assumes the domain object has a primary key
	 * @param vscDomainObjectI $oDomainObject
	 */
	public function outputUpdateSql (vscDomainObjectI $oDomainObject) {
		$sSql = '';
		$aWheres = array();
		$aUpdateFields = array();

		$o = $this->getConnection();
		$sSql = $o->_UPDATE($o->FIELD_OPEN_QUOTE . $oDomainObject->getTableName() . $o->FIELD_CLOSE_QUOTE) . $o->_SET();

		$oPk = $oDomainObject->getPrimaryKey();

		foreach ($oDomainObject->getFields() as $oField) {
			if (!$oPk->hasField ($oField) && $oField->hasValue()) {
				$aUpdateFields[] = $o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE . ' = ' . $this->getQuotedValue($oField->getValue());
			}
		}

		$sSql .= implode (', ', $aUpdateFields);

		foreach ($oPk->getFields() as $oField) {
			$aWheres[] = ($oDomainObject->hasTableAlias() ? $o->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE . '.' : '') .
						$o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE . ' = ' . $this->getQuotedValue($oField->getValue());
		}
		$sSql .= $o->_WHERE(implode ($o->_AND(), $aWheres));

		return $sSql;
	}


	/**
	 * @TODO - next item on the agenda
	 * @param $oDomainObject
	 * @return string
	 */
	public function outputSelectSql (vscDomainObjectI $oDomainObject) {
        $aWheres = array();

		$sRet = $this->getConnection()->_SELECT ($this->getFieldsForSelect($oDomainObject)) .
				$this->getConnection()->_FROM($this->getTableName($oDomainObject, true)) ."\n";

		$sRet .= $this->getConnection()->_WHERE($this->getDefaultWhereClauses($oDomainObject));
		return $sRet;
	}

	/**
	 * Outputs the SQL necessary for creating the table
	 * @return string
	 */
	public function outputCreateTableSQL (vscDomainObjectI $oDomainObject) {
		$sRet = $this->getConnection()->_CREATE ($oDomainObject->getTableName()) . "\n";
		$sRet .= ' ( ' . "\n";

		/* @var $oColumn vscFieldA */
		foreach ($oDomainObject->getFields () as $oColumn) {
			$sRet .= "\t" . $oColumn->getName() . ' ' . $this->getFieldAccess($oColumn)->getDefinition($oColumn) ;
			$sRet .= ', ' . "\n";
		}

		$aIndexes = $oDomainObject->getIndexes(true);
		if (is_array ($aIndexes) && !empty($aIndexes)) {
			foreach ($aIndexes as $oIndex) {
				if (vscIndexA::isValid($oIndex)) {
				// this needs to be replaced with connection functionality : something like getConstraint (type, columns)
					$sRet .=  "\t" . $this->getIndexAccess($oIndex)->getDefinition($oIndex) . ", \n";
				}
			}
		}

		$sRet = substr( $sRet, 0, -3 );

		$sRet.= "\n" . ' ) ';

		if ($this->getConnection()->getType() == vscDbType::mysql) {
			$sRet.= ' ENGINE ' . $this->getConnection()->getEngine();
		}

		return $sRet;
	}

	public function outputDeleteSql (vscDomainObjectI $oDomainObject) {
		$sSql = '';
		$aWheres = array();

		$o = $this->getConnection();
		$sSql = $o->_DELETE($this->getTableName($oDomainObject));

		$oPk = $oDomainObject->getPrimaryKey();

		foreach ($oPk->getFields() as $oField) {
			$aWheres[] = ($oDomainObject->hasTableAlias() ? $o->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE . '.' : '') .
						$o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE . ' = ' . $this->getQuotedValue($oField->getValue());
		}
		$sSql .= $o->_WHERE(implode ($o->_AND(), $aWheres));

		return $sSql;
	}

	public function getTableName (vscDomainObjectI $oDomainObject, $bWithAlias = false) {
		$o = $this->getConnection();

		$sRet = $o->FIELD_OPEN_QUOTE . $oDomainObject->getTableName() . $o->FIELD_CLOSE_QUOTE;
		if ($bWithAlias && $oDomainObject->hasTableAlias()) {
			$sRet .=  $o->_AS($o->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE);
		}

		return $sRet;
	}

	public function getFieldsForSelect (vscDomainObjectI $oDomainObject) {
		$aSelectFields = array ();
		/* @var $oField vscFieldA */

		$o = $this->getConnection();

		foreach ($oDomainObject->getFields() as $oField) {
			if (is_null($oField->getValue())) {
				$aSelectFields[] = ($oDomainObject->hasTableAlias() ? $o->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE . '.' : '') .
								 $o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE .
								 ($oField->hasAlias() ? $o->_AS($o->FIELD_OPEN_QUOTE . $oField->getAlias(). $o->FIELD_CLOSE_QUOTE) : '');
			}
		}

		return implode(', ', $aSelectFields);
	}

	public function getQuotedValue ($mValue) {
		$o = $this->getConnection();
		$mValue		=  $o->escape($mValue);
		if (is_numeric($mValue) || is_null($mValue)) {
			$sCondition = $mValue;
		} elseif (is_string($mValue)) {
			// this should be moved to the sql driver
			$sCondition = $o->STRING_OPEN_QUOTE . $mValue . $o->STRING_CLOSE_QUOTE;
		}

		return $sCondition;
	}

	public function getDefaultWhereClauses (vscDomainObjectI $oDomainObject) {
		$o = $this->getConnection();
		$aWheres = null;
		/* @var $oField vscFieldA */
		foreach ($oDomainObject->getFields() as $oField) {
			if ($oField->hasValue()) {
				$aWheres[]	= ($oDomainObject->hasTableAlias() ? $o->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE . '.' : '') .
							$this->getFieldAccess($oField)->getNameWithValue($oField);
			}
		}

		if ( is_null ($aWheres) ) {
			$aWheres = array ($o->TRUE);
		}

		return implode($o->_AND(), $aWheres);
	}

	/**
	 *
	 * @param vscDomainObjectA $oDomainObject
	 * @param unknown_type $aFieldsArray
	 */
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
			$oPk = $oDomainObject->getPrimaryKey();
			$aIndexFields 		= $oPk->getFields();
			$aIndexFieldNames	= array_keys($aIndexFields);

			// setting the value of each field of the index
			if ($aIndexFieldNames == $aFieldNames) {
				foreach ($aIndexFields as $sFieldName => $oField) {
					$oField->setValue($aFieldsArray[$sFieldName]);
				}
				$bValid = true;
			}
		}

		$this->getConnection()->query($this->outputSelectSql($this->getDomainObject()));

		if ($bValid) {
			$sSql = $this->outputSelectSql($this->getDomainObject());

			$this->getConnection()->query($sSql);
			return $oDomainObject->fromArray($this->getConnection()->getAssoc());
		} else {
			throw new vscExceptionDomain('None of the object unique indexes has all the neccessary values to get an unique instance.');
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/domain/access/vscSqlAccessI#save()
	 */
	public function save (vscDomainObjectA $oDomainObject) {
		$bInsert = false;
		$oPk = $oDomainObject->getPrimaryKey();
		foreach ($oPk->getFields() as $oField) {
			if (!$oField->hasValue()) {
				$bInsert = true;
				break;
			}
		}

		if ($bInsert) {
			$this->insert ($oDomainObject);
		} else {
			$this->update ($oDomainObject);
		}
	}

}
