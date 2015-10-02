<?php
namespace lib\domain\models\IteratorT;
use vsc\domain\models\IteratorTrait;

/**
 * @covers \vsc\domain\models\IteratorTrait::getPropertyNames()
 */
class getPropertyNamesTest extends \PHPUnit_Framework_TestCase {

	public function testBasicGetPropertyNames() {
		$o = new IteratorT_underTest_getPropertyNames();

		$this->assertEquals([
			'test',
			'ana',
			'mere',
			'grrrr'
		], $o->getPropertyNames());
	}
}

class IteratorT_underTest_getPropertyNames {
	use IteratorTrait { getPropertyNames as public;}

	protected $test;
	private $ana;
	public $mere;
	public $grrrr;

	/**
	 * @param string $sKey
	 * @return bool
	 */
	public function offsetExists($sKey)
	{
		// TODO: Implement offsetExists() method.
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
		// TODO: Implement count() method.
	}
}
