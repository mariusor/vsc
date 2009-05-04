<?php
/**
 * The abstract object entity - it represents an entry in the database.
 * It can be composed from more Entity Objects using reflection
 *
 * @package ts_models
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.02.26
 */
usingPackage ('models/foo/fields');
usingPackage ('models/foo/indexes');

abstract class fooEntityA {
	protected 	$name;
	private 	$alias;
	private 	$pk;
	private		$fields = array ();
	private 	$indexes = array ();

	public function __call ($sMethodName, $aParameters) {
//		d ($sMethodName, $aParameters);
		$i = preg_match ('/(set|get)(.*)/i', $sMethodName, $found );
		if ($i) {
			$sMethod	= $found[1];
			$sProperty 	= $found[2];

			$sProperty[0] = strtolower ($sProperty[0]); // lowering the first letter
		}

		if ( $sMethod == 'set' ) {
			// check for fields with $found[1] name
			$this->$sProperty->setValue($aParameters[0]);
			return true;
		} else if ( $sMethod == 'get' ) {
			return $this->$sProperty->getValue();
		}
//		throw new tsExceptionUnimplemented ('Method [' . get_class ($this) . '::' . $sMethodName . ']');
	}

	public function __get ($sPropertyName) {
		return $this->fields[$sPropertyName];
	}

	public function __set ($sPropertyName, $mValue) {
		if (fooFieldA::isValid ($mValue)) {
			$this->fields[$sPropertyName] = $mValue;
		} else {
			$this->fields[$sPropertyName]->setValue($mValue);
		}
	}

	/**
	 * @param string $sName
	 * @return void
	 */
	protected function setName ($sName) {
		$this->name = $sName;
	}

	public function getName () {
		return $this->name;
	}

	/**
	 * @param fooFieldA $oIndex
	 * @return void
	 */
	public function setPrimaryKey () {
		$this->pk = new fooKeyPrimary (func_get_args());
	}

	public function getPrimaryKey () {
		return $this->pk;
	}

	/**
	 * @return fooFieldA[]
	 */
	public function getFields () {
		return $this->fields;
	}

	/**
	 * gets all the column names as an array
	 * @return string[]
	 */
	public function getFieldNames () {
		$aRet = array_keys($this->fields);
		return $aRet;
	}

	public function getIndexes ($bWithPrimaryKey = false) {
		$aIndexes = array ();
		if ($bWithPrimaryKey)
			$aIndexes[] = $this->getPrimaryKey();

		$aIndexes = array_merge ($aIndexes, $this->indexes);

		return $aIndexes;
	}

	/**
	 * returns an array of key=>value for all properties of the current object
	 * @return mixed[]
	 */
	public function toArray () {
		$aRet = array();

		foreach ($this->getFields() as $sFieldName => $oField) {
			$aRet[$sFieldName]	= $oField->getValue();
		}

		return $aRet;
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
	public function fromArray ($aIncArray) {
		foreach ($aIncArray as $sFieldName => $mValue) {
			try {
				$this->fields[$sFieldName]->setValue ($mValue);
			} catch (Exception $e) {
				// dunno what might be thrown here
				d ($e);
				return 0;
			}
		}
		return 1;
	}

	/**
	 *
	 * @param fooEntityA $oChild
	 * @return bool
	 */
	public function loadChild (fooEntityA $oChild) {}
}