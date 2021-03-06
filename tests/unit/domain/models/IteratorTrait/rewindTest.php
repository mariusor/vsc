<?php
namespace tests\domain\models\IteratorTrait;
use vsc\domain\models\CountableTrait;
use vsc\domain\models\IteratorTrait;

/**
 * @covers \vsc\domain\models\ModelA::rewind()
 */
class rewind extends \BaseUnitTest
{
	/**
	 * @covers \vsc\domain\models\ModelA::rewind
	 */
	public function testRewind()
	{
		$o = new IteratorT_underTest_rewind();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties();

		$fp = array_shift($properties);
		foreach ($o as $name => $value) {
			$this->assertNotEmpty($name);
		}
		$o->rewind();

		$oMirror = new \ReflectionClass($o);

		$getCurrentMethod = $oMirror->getMethod('getCurrent');
		$getCurrentMethod->setAccessible(true);

		$this->assertEquals($fp->getName(), $getCurrentMethod->invoke($o));
	}

}

class IteratorT_underTest_rewind implements \Iterator, \Countable {
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
