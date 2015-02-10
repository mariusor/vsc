<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::offsetExists()
 */
class offsetExists extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$key = 'test';
		$value = uniqid($key. ':');
		$a = [$key => $value];
		$o = new ArrayModel($a);
		$this->assertTrue($o->offsetExists($key));
		$o->offsetUnset($key);
		$this->assertFalse($o->offsetExists($key));
	}
}
