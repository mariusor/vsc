<?php
namespace tests\lib\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::getView()
 */
class getView extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ViewHelperA_underTest_getView();

		$this->assertEmpty($o->getView());
	}
}

class ViewHelperA_underTest_getView extends ViewHelperA {}