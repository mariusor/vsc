<?php

namespace lib\domain\models\IteratorT;
use vsc\domain\models\IteratorT;

/**
 * Class setCurrentTest
 * @package lib\domain\models\IteratorT
 * @covers \vsc\domain\models\IteratorT::setCurrent
 */
class setCurrentTest extends \PHPUnit_Framework_TestCase {

	public function testBasicSetCurrent() {
		$test = uniqid('test:');
		$o = new IteratorT_underTest_setCurrent();
		$o->setCurrent($test);

		$this->assertEquals($test, $o->key());
	}
}

class IteratorT_underTest_setCurrent {
	use IteratorT { setCurrent as public; }

	/**
	 * @param string $sKey
	 * @return bool
	 */
	public function offsetExists($sKey)
	{
		return true;
	}

	/**
	 * @param string $sOffset
	 * @param mixed $mValue
	 * @return mixed
	 */
	public function __set($sOffset, $mValue)
	{
		// TODO: Implement __set() method.
	}

	/**
	 * @param string $sOffset
	 * @return mixed
	 */
	public function __get($sOffset)
	{
		// TODO: Implement __get() method.
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return 1;
	}
}
