<?php
namespace tests\application\controllers\XmlController;
use vsc\application\controllers\XmlController;
use vsc\presentation\views\ViewA;
use vsc\presentation\views\XmlView;

/**
 * @covers \vsc\application\controllers\XmlController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testBasicGetDefaultView()
	{
		$s = new XmlController_underTest_getDefaultView();
		$this->assertInstanceOf(XmlView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}

class XmlController_underTest_getDefaultView extends XmlController {
}
