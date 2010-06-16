<?php
/**
 * @package vsc_domain
 * @subpackage access
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.06.01
 */
class vscSqlClauseAccess extends vscObject {
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


	public function getDefinition (vscClause $oClause) {
		if ($oClause->getSubject() === '1' || is_string($oClause->getSubject())) {
			return (string)$oClause->getSubject();
		} elseif ($oClause->getSubject() instanceof vscClause) {
			$subStr = (string)$oClause->getSubject ();
		} elseif ($oClause->getSubject() instanceof vscFieldA) {
			$subStr =  ($oClause->getSubject()->getTableAlias() != 't' ? $oClause->getSubject()->getTableAlias().'.': '') . $oClause->getSubject()->getName();
		} else {
			return '';
		}

		if (is_null($oClause->getPredicative())) {
			if ($oClause->validPredicate ($oClause->getPredicate())) {
				$preStr = 'NULL';
			} else
			$preStr = '';
		} elseif (is_numeric($oClause->getPredicative ())) {
			$preStr = $oClause->getPredicative ();
		} elseif (is_string($oClause->getPredicative ())) {
			$preStr = $oClause->getPredicative ();

			if ($oClause->getPredicate() == 'LIKE') {
				$preStr = '%'.$oClause->getPredicate().'%';
			}

			$preStr = (stripos($preStr, '"') !== 0 ? '"'.$preStr.'"' : $preStr);//'"'.$preStr.'"';
		} elseif (is_array($oClause->getPredicative ())) {
			$preStr =  '("'.implode('", "',$oClause->getPredicative ()).'")';
		} elseif ($oClause->getPredicative () instanceof vscFieldA) {
			$preStr = ($oClause->getPredicative()->getTableAlias() != 't' ? $oClause->getPredicative()->getTableAlias().'.': '').$oClause->getPredicative()->getName();
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