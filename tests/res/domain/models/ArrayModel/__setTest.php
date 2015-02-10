<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::__set()
 */
class __set extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$value = uniqid('test:');
		$key = 'test';
		$o = new ArrayModel();
		$this->assertNull($o->__get($key));
		$o->__set($key, $value);
		$this->assertEquals($value, $o->__get($key));
	}
}
