<?php
namespace tests\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::getProperties()
 */
class getProperties extends \BaseUnitTest
{
	public function testEmptyPropertiesAtInitialization()
	{
		$o = new ArrayModel_underTest_getProperties();
		$this->assertEquals([],$o->getProperties());
	}

	public function testGetPropertiesAfterSet()
	{
		$a = [
			'ana', 'are', 'mere',
			'test' => uniqid('test:')
		];
		$o = new ArrayModel_underTest_getProperties($a);
		$this->assertEquals($a, $o->getProperties());
	}
}

class ArrayModel_underTest_getProperties extends ArrayModel {
	public function getProperties ($bAll = false) {
		return parent::getProperties($bAll);
	}
}
