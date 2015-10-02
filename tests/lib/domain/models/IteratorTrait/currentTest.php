<?php
namespace tests\lib\domain\models\IteratorTrait;
use vsc\domain\models\IteratorTrait;

/**
 * @covers \vsc\domain\models\IteratorTrait::current()()
 */
class current extends \PHPUnit_Framework_TestCase
{
	public function testCurrentAtInitialization()
	{
		$o = new IteratorT_underTest_current();
		$this->assertEquals($o->test, $o->current());

		$oMirror = new \ReflectionObject($o);
		$oOffsetMirror = $oMirror->getProperty('_current');
		$oOffsetMirror->setAccessible(true);

		$sOffset = 'test';
		$o->test = $sOffset;

		$this->assertEquals($sOffset, $oOffsetMirror->getValue($o));
	}

	public function testCurrentAtAttribution()
	{
		$o = new IteratorT_underTest_current();
		$oMirror = new \ReflectionObject($o);
		$oOffsetMirror = $oMirror->getProperty('_current');
		$oOffsetMirror->setAccessible(true);

		$sOffset = 'test';
		$sValue = 'test123';

		$o->$sOffset = $sValue;

		$this->assertEquals($sOffset, $oOffsetMirror->getValue($o));
		$this->assertEquals($sValue, $o->current());
	}
}

class IteratorT_underTest_current implements \Iterator, \Countable {
	use IteratorTrait;

	protected $test;
	protected $another;
	protected $grrr;

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
