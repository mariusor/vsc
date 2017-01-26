<?php
namespace tests\domain\models\CountableTrait;
use vsc\domain\models\CountableTrait;

/**
 * @covers \vsc\domain\models\CountableTrait::count()
 */
class count extends \BaseUnitTest
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
	use CountableTrait;

	public $test;
	public $test123;
	public $another;
}
