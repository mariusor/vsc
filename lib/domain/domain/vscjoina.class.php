<?php
/**
 * @package vsc_domain
 * @subpackage domain
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 10.02.25
 */
class vscJoinA extends vscObject {
	static public $aTypes = array (
		'INNER',
		'LEFT',
		'RIGHT',
		);

	protected	$state;
	protected	$type;
	/**
	 * @var vscEntityA $leftTable
	 */
	protected	$leftTable;
	/**
	 * @var vscEntityA $rightTable
	 */
	protected	$rightTable;

	/**
	 * @var vscFieldA $leftField
	 */
	protected	$leftField;

	/**
	 * @var vscFieldA $rightField
	 */
	protected	$rightField;

	public function __construct ($type, &$lt, &$rt, &$lf, &$rf, $state) {
		if (
			$rt instanceof vscEntityA ||
			$lt instanceof vscEntityA
		) {
			$this->leftTable	= &$lt;
			$this->rightTable	= &$rt;
		}
		if (vscJoinA::isValidType($type))
			$this->type = $type;

		if (
			$lf instanceof vscFieldA &&
			$rf instanceof vscFieldA
		) {
			$this->rightField	= $rf;
			$this->leftField	= $lf;
		}

		$this->state	= $state;

		$this->composeFields ();
		$this->composeWheres ();

	}

	public function __destruct () {}

	public function __toString() {
		$lAlias = $this->leftTable->getAlias();

		return (string)$this->type.' JOIN '.$this->rightTable->getName().
			' AS t'.$this->state.' ON '.(isset($lAlias) ? $lAlias : $this->leftTable->getName()).
			'.'.$this->leftField->name.
			' = t'.$this->state.'.'.$this->rightField->name.' ';
	}

	/**
	 * Will compose the $rightTable and $leftTable fields
	 * @return void
	 */
	public function composeFields () {
		$leftFields		= $this->leftTable->getFields();

		$this->rightTable->setAlias($this->state);
		$rightFields	= $this->rightTable->getFields();

		$this->setFields(array_merge($rightFields, $leftFields));
	}

	public function setFields ($aFields) {
//		$oRObject = new ReflectionObject($this);
		foreach ($aFields as $sFieldName => $oField) {
//			if ($oRObject->hasProperty($sFieldName)) {
//				$oRProperty = new ReflectionProperty($this, $sFieldName);
//				if (!$oRProperty->isPrivate()) {
//					$oRProperty->setValue($this, $oField);
//				} else {
//					// I should throw an access exception;
//					d ('property is private... please replace me with an exception');
//				}
//			} else {
//
//			}
			$this->$sFieldName = $oField;
		}
	}

	/**
	 * Will compose the $rightTable and $leftTable WHERE clauses
	 * @return void
	 */
	public function composeWheres () {
		if (!is_array($this->leftTable->wheres))
			$this->leftTable->wheres =  array();
		if (!is_array($this->rightTable->wheres))
			$this->rightTable->wheres =  array();

		//		var_dump($this->rightTable->wheres, $this->leftTable );die;
		foreach ($this->rightTable->wheres as $where) {
			$this->leftTable->addWhere ($where);
		}
		$this->leftTable->wheres = array_merge($this->rightTable->wheres, $this->leftTable->wheres);
	}

	public function setState ($st) {
		$this->state	= $st;
	}

	static public function isValidType ($inc) {
		if (in_array($inc, vscJoinA::$aTypes))
		return true;
		return false;
	}
}
