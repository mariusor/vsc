<?php

/**
 * class to abstract a where clause in a SQL query
 * TODO: add possibility of complex wheres: (t1 condition1 OR|AND|XOR t2.condition2)
 * TODO: abstract the condition part of a where clause - currently string based :D
 * @package vsc_domain
 * @author marius orcsik <marius@habarnam.ro>
 * @date 10.06.01
 */
class vscClause {
	private	$mSubject;
	private	$sPredicate;
	private	$mPredicative;

	public function getSubject() {
		return $this->mSubject;
	}
	public function getPredicate() {
		return $this->sPredicate;
	}
	public function getPredicative() {
		return $this->mPredicative;
	}

	/**
	 * initializing a WHERE|ON clause
	 *
	 * @param cClause|vscFieldA $mSubject
	 * @param string|null $sPredicate
	 * @param mixed $mPredicative
	 */
	public function __construct ($mSubject, $sPredicate = null, $mPredicative = null) {
		// I must be careful with the $mSubject == 1 because (int)object == 1
		if (($mSubject === 1 || is_string($mSubject)) && $sPredicate == null && $mPredicative == null) {
			$this->mSubject		= $mSubject;
			$this->sPredicate	= '';
			$this->mPredicative	= '';
			return;
		}

		if (($mSubject instanceof vscFieldA) || ($mSubject instanceof vscClause )) {
			$this->mSubject 	= $mSubject;
			$this->mPredicative	= $mPredicative;
			if ($this->validPredicate ($sPredicate)) {
				$this->sPredicate	= $sPredicate;
			} else {
				$this->sPredicate	= $sPredicate;
			}
		} else {
			$this->mSubject		= '';
			$this->sPredicate	= '';
			$this->mPredicative	= '';

			return;
		}
	}

	public function validPredicate ($sPredicate) {
		return true;
	}
}
