<?php
namespace tests\res\application\controllers\XhtmlController;
use vsc\application\controllers\XhtmlController;
use vsc\presentation\views\ViewA;
use vsc\presentation\views\XhtmlView;

/**
 * @covers the public method XhtmlController::getDefaultView()
 */
class getDefaultView extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetDefaultView()
	{
		$s = new XhtmlController_underTest_getDefaultView();
		$this->assertInstanceOf(XhtmlView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}

class XhtmlController_underTest_getDefaultView extends XhtmlController {
}
