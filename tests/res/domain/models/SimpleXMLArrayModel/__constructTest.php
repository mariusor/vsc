<?php
namespace tests\res\domain\models\SimpleXMLArrayModel;
use vsc\domain\models\SimpleXMLArrayModel;

/**
 * @covers \vsc\domain\models\SimpleXMLArrayModel::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$a = new \stdClass();
		$value = uniqid('test:');
		$key = 'test';
		$a->$key = $value;
		$o = new SimpleXMLArrayModel($a);
		$this->assertInstanceOf(SimpleXMLArrayModel::class, $o);
	}
}
