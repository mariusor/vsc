<?php
namespace tests\domain\models\IteratorTrait;
use vsc\domain\models\CountableTrait;
use vsc\domain\models\IteratorTrait;

/**
 * @covers \vsc\domain\models\IteratorTrait::next()
 */
class next extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\ModelA::next
	 */
	public function testNext()
	{
		$o = new IteratorT_underTest_next();

		$oMirror = new \ReflectionClass($o);

		$getCurrentMethod = $oMirror->getMethod('getCurrent');
		$getCurrentMethod->setAccessible(true);

		foreach ($o as $key => $value) {
			$this->assertNotEmpty($key);
			$this->assertEquals($key, $getCurrentMethod->invoke($o));
		}
	}
}

class IteratorT_underTest_next implements \Iterator, \Countable {
	use IteratorTrait;
	use CountableTrait;

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
