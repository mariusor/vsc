<?php
namespace tests\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::offsetGet()
 */
class offsetGet extends \BaseUnitTest
{
	public function testOffsetGetWithAndWithoutSetValue()
	{
		$key = 'test';
		$value = uniqid($key. ':');
		$o = new ArrayModel();
		$this->assertNull($o->offsetGet($key));
		$o->offsetSet($key, $value);
		$this->assertEquals($value, $o->offsetGet($key));
		$this->assertEquals($value, $o[$key]);
	}
}
