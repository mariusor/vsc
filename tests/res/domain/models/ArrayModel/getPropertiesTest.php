<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::getProperties()
 */
class getProperties extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new ArrayModel_underTest_getProperties();
		$this->assertEquals([],$o->getProperties());
	}
}

class ArrayModel_underTest_getProperties extends ArrayModel {
	public function getProperties ($bAll = false) {
		return parent::getProperties($bAll);
	}
}
