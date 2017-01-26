<?php
namespace tests\application\controllers\XhtmlController;
use vsc\application\controllers\XhtmlController;
use vsc\presentation\views\ViewA;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\application\controllers\XhtmlController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
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
