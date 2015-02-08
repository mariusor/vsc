<?php
namespace tests\res\domain\models\SimpleXMLArrayModel;
use vsc\domain\models\SimpleXMLArrayModel;

/**
 * @covers \vsc\domain\models\SimpleXMLArrayModel::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		return $this->markTestIncomplete('grr');
		$a = new \stdClass();
		$value = uniqid('test:');
		$method = 'call';
		$key = 'test';
		$a->$key = $value;
		$o = new SimpleXMLArrayModel($a);
		$this->assertEquals($value, $o->__call($method, [$value]));
	}
}
