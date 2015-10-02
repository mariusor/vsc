<?php
namespace mocks\domain\models ;

use \vsc\domain\models\ModelA;

class ModelFixture extends ModelA {
	public $test = 666;
	public $cucu;

	private $needsGetter = true;

	public function valid ($sName = null) {
		return parent::valid($sName);
	}

	// Countable interface
	public function count () {
		return parent::count();
	}

	public function getPropertyNames ($bAll = false) {
		return parent::getPropertyNames($bAll);
	}

	/**
	 *
	 * @param bool $bIncludeProtected
	 * @return array
	 */
	public function getProperties ($bIncludeProtected = false) {
		return parent::getProperties($bIncludeProtected);
	}

	/**
	 * recursively transform all properties into arrays
	 */
	public function toArray () {
		return parent::toArray();
	}

	/**
	 * @return bool
	 */
	public function getNeedsGetter() {
		return $this->needsGetter;
	}
}
