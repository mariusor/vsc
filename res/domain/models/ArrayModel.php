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
/**/
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

		//parent::__construct();
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

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current()
	{
		return current($this->aContent);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		return next($this->aContent);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key()
	{
		return key($this->aContent);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid()
	{
		return array_key_exists($this->key(), $this->aContent);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		return rewind($this->aContent);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count()
	{
		return count($this->aContent);
	}
}
