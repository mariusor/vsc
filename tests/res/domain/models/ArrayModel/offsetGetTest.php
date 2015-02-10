<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::offsetGet()
 */
class offsetGet extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
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
