<?php
namespace tests\lib\domain\models\CountableT;
use vsc\domain\models\CountableT;

/**
 * @covers \vsc\domain\models\ModelA::count()
 */
class count extends \PHPUnit_Framework_TestCase
{

	public function testCount()
	{
		$o = new CountableT_underTest_count();

		$oMirror = new \ReflectionClass($o);
		$properties = $oMirror->getProperties(\ReflectionProperty::IS_PUBLIC);

		$this->assertEquals(count($properties), $o->count());
		$this->assertEquals(count($properties), count($o));
	}
}

class CountableT_underTest_count implements \Countable {
	use CountableT;

	public $test;
	public $test123;
	public $another;
}