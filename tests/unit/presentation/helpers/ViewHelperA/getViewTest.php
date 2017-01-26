<?php
namespace tests\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::getView()
 */
class getView extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new ViewHelperA_underTest_getView();

		$this->assertEmpty($o->getView());
	}
}

class ViewHelperA_underTest_getView extends ViewHelperA {}
