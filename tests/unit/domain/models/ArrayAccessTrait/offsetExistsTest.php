<?php
namespace tests\domain\models\ArrayAccessTrait;
use vsc\domain\models\ArrayAccessTrait;

/**
 * @covers \vsc\domain\models\ArrayAccessTrait::offsetExists()
 */
class offsetExists extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\ModelA::offsetExists
	 */
	public function testBasicOffsetExists()
	{
		$o = new ArrayAccessT_underTest_offsetExists();

		$sExistentOffset = 'test';
		$this->assertTrue($o->offsetExists($sExistentOffset));

		$sInexistentOffset = uniqid();
		$this->assertFalse($o->offsetExists($sInexistentOffset));
	}

}

class ArrayAccessT_underTest_offsetExists implements \ArrayAccess {
	use ArrayAccessTrait;

	public $test;
	public $ana = 'test';
	public $mere = 123;
	public $grr = 6.66;
	private $private = 'ana-are-mere';

	/**
	 * @param string $sOffset
	 * @param mixed $mValue
	 * @return mixed
	 */
	public function __set($sOffset, $mValue)
	{
		$this->$sOffset = $mValue;
	}

	/**
	 * @param string $sOffset
	 * @return mixed
	 */
	public function __get($sOffset)
	{
		return $this->$sOffset;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset)
	{
		return in_array($offset, ['test', 'ana', 'mere', 'grr', 'private']);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset)
	{
		return $this->$offset;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->$offset = $value;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		$this->$offset = null;
	}
}
