<?php
namespace tests\lib\presentation\helpers\ViewHelperA;
use vsc\presentation\helpers\ViewHelperA;
use fixtures\presentation\views\NullView;

/**
 * @covers \vsc\presentation\helpers\ViewHelperA::setView()
 */
class setView extends \PHPUnit_Framework_TestCase
{
	public function testBasicsetView()
	{
		$o = new ViewHelperA_underTest_setView();

		$oTestView = new NullView();
		$o->setView($oTestView);
		$oView = $o->getView();

		$this->assertSame($oTestView, $oView
		);
	}
}

class ViewHelperA_underTest_setView extends ViewHelperA {}