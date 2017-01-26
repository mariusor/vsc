<?php
namespace tests\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::getModel()
 */
class getModel extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ViewHelperA_underTest_getModel();

		$this->assertEmpty($o->getModel());
	}
}

class ViewHelperA_underTest_getModel extends ViewHelperA {}
