<?php
/**
 * The abstract object entity - it represents an entry in the database.
 * It can be composed from more Entity Objects using reflection
 *
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.02.26
 */

abstract class fooEntityA {
	protected 	$_name;
	private 	$_alias;
	private 	$_pk;
	private 	$_indexes = array ();

	public function __call ($sMethodName, $aParameters) {
		throw new tsExceptionUnimplemented ('Method [' . get_class ($this) . '::' . $sMethodName . ']');
	}

	public function __get($sProprietyName) {
		throw new tsExceptionUnimplemented ('Property [' . get_class ($this) . '::' . $sMethodName . '] doesn\'t exist');
	}

	public function __set($sProprietyName, $mValue) {
		throw new tsExceptionUnimplemented ('Property [' . get_class ($this) . '::' . $sMethodName . '] doesn\'t exist');
	}

	/**
	 * @param string $sName
	 * @return void
	 */
	protected function setName ($sName) {
		$this->_name = $sName;
	}

	public function getName () {
		return $this->_name;
	}

	/**
	 * @param fooFieldA $oIndex
	 * @return void
	 */
	public function setPrimaryKey (fooFieldA $oColumn) {
		$this->_pk = new fooKeyPrimary ($oColumn);
	}

	public function getPrimaryKey () {
		return $this->_pk;
	}

	/**
	 * @return fooFieldA[]
	 */
	public function getMembers () {
		$aMembers = array();
		$oReflector = new ReflectionClass (get_class($this));
		$aReflectedProperties = $oReflector->getProperties ();

		foreach ($aReflectedProperties as $oProperty) {
			if ($oProperty->isPublic()) // this will need to be fixed asap (ie, php 5.3.0)
				$aMembers[] = $oProperty->getValue ($this);
		}

		return $aMembers;
	}

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getColumnNames () {
		$aRet = array();
		$oReflector = new ReflectionClass (get_class($this));
		$aReflectedProperties = $oReflector->getProperties ();

		foreach ($aReflectedProperties as $oProperty) {
			$sName = $oProperty->getName();
			$aRet[] = $sName;
		}

		return $aRet;
	}

	public function getIndexes () {
		$aIndexes = array ();
		$aIndexes[] = $this->getPrimaryKey();

//		$aIndexes = array_merge($aIndexes, $this->_indexes);

		return $aIndexes;
	}

	/**
	 * returns an array of key=>value for all properties of the current object
	 * @return mixed[]
	 */
	public function toArray () {
	}

	/**
	 * Receives an array of keys=> values and constructs an entity based on
	 * the existing ones.
	 * Returns:
	 * 1 if all array keys existed as properties of the object
	 * 0 if one of the keys didn't exist as a property of the object
	 * 2 if there were properties which didn't have a corresponding key=>value pair
	 * @param mixed[string] $aIncArray
	 * @return int
	 */
	public function fromArray ($aIncArray) {}

	/**
	 *
	 * @param fooEntityA $oChild
	 * @return bool
	 */
	public function loadChild (fooEntityA $oChild) {}

}