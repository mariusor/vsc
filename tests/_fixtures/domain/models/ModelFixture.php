<?php
namespace _fixtures\domain\models ;

use \vsc\domain\models\ModelA;

class ModelFixture extends ModelA {
	public $test = 666;
	public $cucu;

	public function valid ($sName = null) {
		return parent::valid($sName);
	}

	// Countable interface
	public function count () {
		return parent::count();
	}

	/**
	 * It should add a new property to the object
	 * @param string $sName
	 * @param mixed $mValue
	 */
	public function addProperty ($sName, $mValue, $bIfNonExistent = false) {
		parent::addProperty($sName, $mValue, $bIfNonExistent);
	}

	public function getPropertyNames ($bAll = false) {
		return parent::getPropertyNames($bAll);
	}

	/**
	 *
	 * @param bool $bIncludeNonPublic
	 * @return array
	 */
	public function getProperties ($bIncludeNonPublic = false) {
		return parent::getProperties($bIncludeNonPublic);
	}

	/**
	 * recursively transform all properties into arrays
	 */
	public function toArray () {
		return parent::toArray();
	}
}
