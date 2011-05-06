<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.06.01
 */
class vscSqlClauseAccess extends vscObject {
	private $oGrammarHelper;
	/**
	 * @param vscConnectionA $oConnection
	 * @return void
	 */
	public function setGrammarHelper ($oGrammarHelper) {
		$this->oGrammarHelper = $oGrammarHelper;
	}

	/**
	 * @return vscConnectionA
	 */
	public function getConnection () {
		return $this->oGrammarHelper;
	}


	public function getDefinition (vscClause $oClause) {
		if (is_string($oClause->getSubject())) {
			return $oClause->getSubject();
		} elseif ($oClause->getSubject() instanceof vscClause) {
			$subStr = $this->getDefinition($oClause->getSubject ());
		} elseif (vscFieldA::isValid($oClause->getSubject())) {
			$subStr =  ($oClause->getSubject()->getTableAlias() ?
				$this->getConnection()->FIELD_OPEN_QUOTE . $oClause->getSubject()->getTableAlias() . $this->getConnection()->FIELD_CLOSE_QUOTE . '.': '') .
				$this->getConnection()->FIELD_OPEN_QUOTE . $oClause->getSubject()->getName() . $this->getConnection()->FIELD_CLOSE_QUOTE;
		} else {
			return '';
		}

		if (is_null($oClause->getPredicative())) {
			if ($oClause->validPredicate ($oClause->getPredicate())) {
				$preStr = 'NULL';
			} else {
				$preStr = '';
			}
		} elseif (is_numeric($oClause->getPredicative ())) {
			$preStr = $oClause->getPredicative ();
		} elseif (is_string($oClause->getPredicative ())) {
			$preStr = $this->getConnection()->escape($oClause->getPredicative ());

			if ($oClause->getPredicate() == 'LIKE') {
				$preStr = '%'.$preStr.'%';
			}

			$preStr = (stripos($preStr, '"') !== 0 ? '"'.$preStr.'"' : $preStr);//'"'.$preStr.'"';
		} elseif (is_array($oClause->getPredicative ())) {
			//FIXME: escape elements of the predicative array
			$preStr =  '("'.implode('", "',$oClause->getPredicative ()).'")';
		} elseif ($oClause->getPredicative () instanceof vscFieldA) {
			$preStr = ($oClause->getPredicative()->getTableAlias() != 't' ? $this->getConnection()->FIELD_OPEN_QUOTE . $oClause->getPredicative()->getTableAlias() . $this->getConnection()->FIELD_CLOSE_QUOTE .'.': '').
					$this->getConnection()->FIELD_OPEN_QUOTE . $oClause->getPredicative()->getName(). $this->getConnection()->FIELD_CLOSE_QUOTE;
		} elseif ($oClause->getPredicative () instanceof vscClause) {
			$subStr = $subStr;
			$preStr = $oClause->getPredicative ();
		}

		$retStr = $subStr.' '.$oClause->getPredicate().' '.$preStr;
		if (($oClause->getSubject () instanceof vscClause) && ($oClause->getPredicative () instanceof vscClause))
			return '('.$retStr.')';

		return $retStr;
	}

	static public function getValidPredicate (vscClause $oClause) {
		// need to find a way to abstract these
		//		$validPredicates = array (
		//			'AND',
		//			'&&',
		//			'OR',
		//			'||',
		//			'XOR',
		//			'IS',
		//			'IS NOT',
		//			'!',
		//			'IN',
		//			'LIKE',
		//			'=',
		//			'!=',
		//			'<>'
		//		);

		$mPredicative	= $oClause->getPredicative();
		$sPredicate		= $oClause->getPredicate();
		if ($mPredicative instanceof vscClause) {
			// we'll have Subject AND|OR|XOR Predicative
			$validPredicates = array (
				'and',
				'&&',
				'or',
				'||',
				'xor'
				);
		} elseif (($mPredicative instanceof vscFieldA) || is_numeric($mPredicative)) {
			// we'll have Subject =|!= Predicative
			$validPredicates = array (
				'=',
				'!=',
				'>',
				'<',
				'>=',
				'<='
				);
		} elseif (is_array($mPredicative)) {
			$validPredicates = array (
				'in',
				'not in'
				);
		} elseif (is_string($mPredicative)) {
			$validPredicates = array (
				'=',
				'like',
			// dates
				'>',
				'<',
				'>=',
				'<='
				);
		} elseif (is_null($mPredicative)) {
			$validPredicates = array (
				'is',
				'is not'
				);
		}

		return $validPredicates;
	}
}