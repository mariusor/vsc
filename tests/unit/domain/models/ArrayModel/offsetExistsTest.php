<?php
namespace tests\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::offsetExists()
 */
class offsetExists extends \BaseUnitTest
{
	public function testOffsetExistsWithAndWithoutCorrectKey()
	{
		$key = 'test';
		$value = uniqid($key. ':');
		$a = [$key => $value];
		$o = new ArrayModel($a);

		$this->assertTrue($o->offsetExists($key));
		$this->assertFalse($o->offsetExists(uniqid()));

		$o->offsetUnset($key);
		$this->assertFalse($o->offsetExists($key));
	}
}
