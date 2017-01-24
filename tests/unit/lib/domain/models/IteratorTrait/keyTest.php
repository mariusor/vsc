<?php
namespace tests\lib\domain\models\IteratorTrait;
use vsc\domain\models\CountableTrait;
use vsc\domain\models\IteratorTrait;

/**
 * @covers \vsc\domain\models\IteratorTrait::key()
 */
class key extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\ModelA::key()
	 */
	public function testKeyAtInitializationUsingReflectionOnModelA()
	{
		$o = new IteratorT_underTest_key();

		$oMirror = new \ReflectionClass($o);
		$oOffsetMirror = $oMirror->getProperty('_current');
		$oOffsetMirror->setAccessible(true);

		$this->assertEquals($oOffsetMirror->getValue($o), $o->key());
	}

	/**
	 * @covers \vsc\domain\models\ModelA::key()
	 */
	public function testKeyAtInitializationUsingPublicPropertiesReflection()
	{
		$o = new IteratorT_underTest_key();

		$oMirror = new \ReflectionClass($o);
		$aProperties = $oMirror->getProperties();

		// first property should be returned by IteratorTrait::key()
		$sReflectionKey = array_shift($aProperties)->getName();

		$current = $o->key();
		$this->assertEquals($sReflectionKey, $current);
	}
}

class IteratorT_underTest_key implements \Iterator, \Countable {
	use IteratorTrait;
	use CountableTrait;

	protected $test;
	protected $another;
	protected $grrr;

	public function __construct() {
		$this->_current = 'test';
	}

	/**
	 * @param string $sOffset
	 * @param mixed $mValue
	 * @return mixed
	 */
	public function __set($sOffset, $mValue)
	{
		$this->_current = $sOffset;
		$this->$sOffset = $mValue;
	}

	/**
	 * @param string $sOffset
	 * @return mixed
	 */
	public function __get($sOffset)
	{
		$this->_current = $sOffset;
		return $this->$sOffset;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return 3;
	}

	/**
	 * @param string $sKey
	 * @return bool
	 */
	public function offsetExists($sKey)
	{
		return in_array($sKey, ['test', 'another', 'grrr']);
	}
}
