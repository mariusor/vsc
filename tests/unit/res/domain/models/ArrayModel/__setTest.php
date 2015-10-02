<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::__set()
 */
class __set extends \PHPUnit_Framework_TestCase
{
	public function test__setUsingCall()
	{
		$value = uniqid('test:');
		$key = 'test';
		$o = new ArrayModel();

		$this->assertNull($o[$key]);

		$o->__set($key, $value);
		$this->assertEquals($value, $o[$key]);
	}

	public function test__setUsingBracketsOperator()
	{
		$value = uniqid('test:');
		$key = 'test';
		$o = new ArrayModel();
		$this->assertNull($o[$key]);

		$o[$key] = $value;
		$this->assertEquals($value, $o[$key]);
	}
}
