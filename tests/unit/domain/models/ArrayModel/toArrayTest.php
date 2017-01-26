<?php
namespace tests\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::toArray()
 */
class toArray extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ArrayModel();
		$this->assertEquals([], $o->toArray());
	}
}
