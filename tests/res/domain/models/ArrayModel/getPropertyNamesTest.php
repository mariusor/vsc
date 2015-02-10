<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::getPropertyNames()
 */
class getPropertyNames extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ArrayModel_underTest_getPropertyNames();
		$this->assertEquals([], $o->getPropertyNames());
	}

	public function testBasicGetPropertyNames()
	{
		$a = [
			'test' => 123,
			'ana' => 0x12,
			'mere' => 'a'
		];
		$o = new ArrayModel_underTest_getPropertyNames($a);
		$this->assertEquals(array_keys($a), $o->getPropertyNames());
	}
}

class ArrayModel_underTest_getPropertyNames extends ArrayModel {
	public function getPropertyNames ($bAll = false) {
		return parent::getPropertyNames($bAll);
	}
}
