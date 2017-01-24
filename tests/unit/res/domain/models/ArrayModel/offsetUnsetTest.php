<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::offsetUnset()
 */
class offsetUnset extends \BaseUnitTest
{
	public function testBasicOffsetUnset()
	{
		$key = 'test';
		$value = uniqid($key. ':');
		$a = [$key => $value];
		$o = new ArrayModel($a);
		$this->assertEquals($value, $o[$key]);
		$o->offsetUnset($key);
		$this->assertNull($o[$key]);
	}
}
