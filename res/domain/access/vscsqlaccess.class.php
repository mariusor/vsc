<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.04.01
 */
import ('domain/domain');
import ('domain/access/clauses');
import ('domain/domain/clauses');
import ('domain/access/joins');
import ('domain/domain/joins');

class vscSqlAccess extends vscSqlAccessA {
	private $aGroupBys	= array();
	private $aOrderBys	= array();
	private $aClauses	= array();
	private $aJoins		= array();
	private $iStart;
	private $iCount;

	private $oFactory;

	final public function __construct() {
		parent::__construct();

		$this->oFactory = new vscAccessFactory();
		$this->oFactory->setConnection($this->getConnection());
	}

	public function getAccess($oObject = null) {
		if ($oObject instanceof vscJoinA) {
			return $this->oFactory->getJoin($oObject);
		}

		if ($oObject instanceof vscFieldA) {
			return $this->oFactory->getField($oObject);
		}

		if ($oObject instanceof vscIndexA) {
			return $this->oFactory->getIndex($oObject);
		}

		if (is_null($oObject) || $oObject instanceof vscClause) {
			return $this->oFactory->getClause($oObject);
		}
	}

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
				$aRet[$oField->getName()] = $this->getAccess($oField)->escapeValue($oField);
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
	public function outputSelectSql () {
		$aParameters = func_get_args();
		$aSelects = $aNames = array ();

		if (count($aParameters) == 1 && is_array($aParameters)) {
			// some of the functions get the arguments themselves and pass them as an array
			$aParameters = $aParameters[0];
		}

		foreach ($aParameters as $key => $oParameter) {
			if (!($oParameter instanceof vscDomainObjectI)) {
				unset ($aParameters[$key]);
				continue;
			}
			/* @var $oParameter vscDomainObjectA */
			$oParameter->setTableAlias('t'.$key);
			$aSelects[] =  $this->getFieldsForSelect($oParameter, true);

			$aNames[] = $this->getTableName($oParameter, true);
			$this->buildDefaultClauses($oParameter);
		}

        $aWheres = array();

		$sRet = $this->getConnection()->_SELECT (implode (', ', $aSelects)) .
				$this->getConnection()->_FROM(implode (', ', $aNames)) ."\n" .
//				$this->getJoinsString() .
				$this->getConnection()->_WHERE($this->getClausesString ()) .
				$this->getGroupByString() .
				$this->getOrderByString() .
				$this->getLimitString();

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
			$sRet .= "\t" . $oColumn->getName() . ' ' . $this->getAccess($oColumn)->getDefinition($oColumn) ;
			$sRet .= ', ' . "\n";
		}

		$aIndexes = $oDomainObject->getIndexes(true);
		if (is_array ($aIndexes) && !empty($aIndexes)) {
			foreach ($aIndexes as $oIndex) {
				if (vscIndexA::isValid($oIndex)) {
				// this needs to be replaced with connection functionality : something like getConstraint (type, columns)
					$sRet .=  "\t" . $this->getAccess($oIndex)->getDefinition($oIndex) . ", \n";
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

	public function getFieldsForSelect (vscDomainObjectI $oDomainObject, $bWithAlias = false) {
		$aSelectFields = array ();
		/* @var $oField vscFieldA */

		$o = $this->getConnection();

		foreach ($oDomainObject->getFields() as $oField) {
			if (is_null($oField->getValue())) {
				$aSelectFields[] = ($oDomainObject->hasTableAlias() ? $o->FIELD_OPEN_QUOTE . $oDomainObject->getTableAlias() . $o->FIELD_CLOSE_QUOTE . '.' : '') .
								 $o->FIELD_OPEN_QUOTE . $oField->getName() . $o->FIELD_CLOSE_QUOTE .
								 ($bWithAlias && $oField->hasAlias() ? $o->_AS($o->FIELD_OPEN_QUOTE . $oField->getAlias(). $o->FIELD_CLOSE_QUOTE) : '');
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

	public function buildDefaultClauses (vscDomainObjectI $oDomainObject) {
		$o = $this->getConnection();
		$aWheres = array();
		/* @var $oField vscFieldA */
		foreach ($oDomainObject->getFields() as $oField) {
			if ($oField->hasValue()) {
				$aWheres[]	= new vscClause($oField, '=', $oField->getValue());
			}
		}

		if (count($this->aClauses) == 0 && count($aWheres) == 0) {
			$this->aClauses = array (new vscClause ($o->TRUE));
		} else {
			$this->aClauses = array_merge($this->aClauses, $aWheres);
		}
	}

	/**
	 *
	 * @param vscDomainObjectA $oDomainObject
	 * @param unknown_type $aFieldsArray
	 */
	public function loadByFilter () { // this shold be moved to the composite model
		$aParameters = func_get_args();
		$aSelects = $aNames = array ();

		foreach ($aParameters as $key => $oParameter) {
			if (!($oParameter instanceof vscDomainObjectI)) {
				unset ($aParameters[$key]);
			}
		}
		$aRet = array();
		$aTotalValues =  array();

		$a = $this->getConnection()->query($this->outputSelectSql($aParameters));

		foreach ($aParameters as $oParameter) {
			$sLabel = $oParameter->getTableAlias() ? $oParameter->getTableAlias() : $oParameter->getTableName();
			$aTypes[$sLabel] = get_class($oParameter);
		}

		for ($i = 0; $i < $a->num_rows; $i++) {
			foreach ($this->getConnection()->getAssoc() as $sKey => $sValue) {
				$sTableAlias	= substr($sKey, 0, strpos($sKey, '.'));
				$sFieldName 	= substr($sKey, strpos($sKey, '.')+1);

				$aTotalValues[$sTableAlias][$i][$sFieldName] = $sValue;
			}
		}

		foreach ($aTotalValues as $sAlias => $aValuesArray) {
			$sType = $aTypes[$sAlias];
			foreach ($aValuesArray as $iKey => $aValues){
				$oDomainObject = new $sType();
				$oDomainObject->fromArray ($aValues);

				$aRet[$iKey][$sAlias] = $oDomainObject;
			}
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

	public function where ($mSubject, $sPredicate= null, $mPredicative = null) {
		if (($mSubject instanceof vscClause) && ($sPredicate == null || $mPredicative == null)) {
			$w = $mSubject;
		} else {
			$w = new vscClause($mSubject, $sPredicate, $mPredicative);
		}
		// this might generate an infinite recursion error on some PHP > 5.2 due to object comparison
		if (!in_array ($w, $this->aClauses/*, true*/)) {
			$this->aClauses[]	= $w;
		}
		return $this;
	}

	public function join (vscFieldA $oLeftField, vscFieldA $oRightField) {
		$w = new vscJoinInner($oLeftField, $oRightField);
		if (!in_array ($w, $this->aJoins/*, true*/)) {
			$this->aJoins[]	= $w;
		}
		$this->where ($oLeftField, '=', $oRightField);
		return $this;
	}

	public function getClausesString () {
		$sStr = '';
		$aStrClauses = array();
		if (count ($this->aClauses) > 0 ) {
			foreach ($this->aClauses as $oClause) {
				$aStrClauses[] .= $this->getAccess()->getDefinition($oClause);
			}

			$sStr = implode ($this->getConnection()->_AND(), $aStrClauses);
		}

		return $sStr;
	}

	public function setLimit ($iStart, $iCount = null) {
		if ($iCount === null) {
			$iCount = $iStart;
			$iStart = 0;
		}
		$this->iStart = $iStart;
		$this->iCount = $iCount;
	}

	public function getLimitString() {
		return $this->getConnection()->_LIMIT ($this->iStart, $this->iCount);
	}

	public function groupBy (vscFieldA $oField) {
		if (!key_exists($oField->getName(), $this->aGroupBys)) {
			$this->aGroupBys[$oField->getName()] = $oField;
		}
		return $this;
	}

	public function orderBy (vscFieldA $oField, $bAscending = true) {
		if ($bAscending) {
			$sDirection = ' ASC';
		} else {
			$sDirection = ' DESC';
		}
		if (!key_exists($oField->getName(), $this->aOrderBys)) {
			$this->aOrderBys[$oField->getName()] =  array (
				$oField,
				$sDirection
			);
		}
		return $this;
	}

	public function getGroupByString () {
		$sGroupBy = '';
		if (count ($this->aGroupBys) > 0 ) {
			foreach ($this->aGroupBys as $oField) {
				$oDomainObject = $oField->getParent();
				$sGroupBy .= ($oField->hasAlias() ? $oField->getAlias() : $oField->getName());   
			}
			return $this->getConnection()->_GROUP($sGroupBy);
		} else {
			return '';
		}
	}

	public function getOrderByString () {
		$sOrderBy = '';
		if (count ($this->aOrderBys) > 0 ) {
			foreach ($this->aOrderBys as $aOrderBy) {
				$oField = $aOrderBy[0];
				$sDirection = $aOrderBy[1];
				$sOrderBy = ($oField->hasAlias() ? $oField->getAlias() : $oField->getName()) . ' '. $sDirection ;
			}

			return $this->getConnection()->_ORDER($sOrderBy);
		} else {
			return '';
		}
	}

	public function getJoinsString () {
		$sStr = '';
		$aStrJoins = array();
		if (count ($this->aJoins) > 0 ) {
			foreach ($this->aJoins as $oJoin) {
				$aStrJoins[] .= $this->getAccess($oJoin)->getDefinition($oJoin);
			}

			$sStr = implode (', ', $aStrJoins);
		}

		return $sStr;
	}
}
