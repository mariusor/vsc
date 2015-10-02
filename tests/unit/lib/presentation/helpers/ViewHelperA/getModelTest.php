<?php
namespace tests\lib\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::getModel()
 */
class getModel extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new ViewHelperA_underTest_getModel();

		$this->assertEmpty($o->getModel());
	}
}

class ViewHelperA_underTest_getModel extends ViewHelperA {}