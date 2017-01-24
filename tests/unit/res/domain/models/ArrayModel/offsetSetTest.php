<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::offsetSet()
 */
class offsetSet extends \BaseUnitTest
{
	public function testBasicOffsetSet()
	{
		$key = 'test';
		$value = uniqid($key. ':');
//		$a = [$key => $value];
		$o = new ArrayModel();
		$this->assertFalse($o->offsetExists($key));
		$o->offsetSet($key, $value);
		$this->assertTrue($o->offsetExists($key));
		$this->assertEquals($value, $o[$key]);
	}
}
