<?php
namespace tests\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::__get()
 */
class __get extends \BaseUnitTest
{
	public function testEmpty__getAtInitialization()
	{
		$o = new ArrayModel();
		$this->assertNull($o->__get('test'));
	}

	public function testBasic__getCalledAndByBracketsOperator()
	{
		$a = [
			'test' => uniqid('test:')
		];
		$o = new ArrayModel($a);
		$this->assertEquals($a['test'], $o->__get('test'));
		$this->assertEquals($a['test'], $o['test']);
	}
}
