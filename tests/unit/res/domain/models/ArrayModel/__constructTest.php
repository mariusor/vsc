<?php
namespace tests\res\domain\models\ArrayModel;
use vsc\domain\models\ArrayModel;

/**
 * @covers \vsc\domain\models\ArrayModel::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ArrayModel();
		$this->assertEquals(0, $o->count());
		$this->assertEquals(0, count($o));
		$this->assertEquals([], $o->toArray());
	}
}
