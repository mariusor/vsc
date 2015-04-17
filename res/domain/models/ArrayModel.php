<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.15
 */
namespace vsc\domain\models;

class ArrayModel extends ModelA implements ModelI {
	protected $aContent = array();
	private $length;

	protected function getProperties($bAll = false) {
		return $this->aContent;
	}

	protected function getPropertyNames($bAll = false) {
		return array_keys($this->aContent);
	}

	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->aContent[] = $value;
			$this->setCurrent(array_search($value, $this->aContent));
		} else {
			$this->aContent[$offset] = $value;
			$this->setCurrent($offset);
		}
	}
	public function offsetExists($offset) {
		return isset($this->aContent[$offset]);
	}
	public function offsetUnset($offset) {
		unset($this->aContent[$offset]);
	}
	public function offsetGet($offset) {
		return isset($this->aContent[$offset]) ? $this->aContent[$offset] : null;
	}

	public function __construct($aIncArray = array()) {
		$this->aContent = $aIncArray;
		$this->length = count($aIncArray);
	}

	public function __get($sIncName = null) {
		if (!is_null($sIncName) && isset($this->aContent[$sIncName])) {
			return $this->aContent[$sIncName];
		}
		return null;
	}

	public function __set($sIncName, $value) {
		$this->aContent[$sIncName] = $value;
		$this->setCurrent($sIncName);
		$this->length = count($this->aContent);
	}

	public function toArray() {
		return $this->aContent;
	}
}
