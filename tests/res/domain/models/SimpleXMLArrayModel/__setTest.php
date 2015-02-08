<?php
namespace tests\res\domain\models\SimpleXMLArrayModel;
use vsc\domain\models\SimpleXMLArrayModel;

/**
 * @covers \vsc\domain\models\SimpleXMLArrayModel::__set()
 */
class __set extends \PHPUnit_Framework_TestCase
{
	public function testBasic__set()
	{
		$a = new \stdClass();
		$key = 'test';
		$value = uniqid('test:');
		$o = new SimpleXMLArrayModel($a);
		$this->assertNull($o->__set($key, $value));
	}
}
