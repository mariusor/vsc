<?php
namespace tests\res\application\controllers\XmlController;
use vsc\application\controllers\XmlController;
use vsc\presentation\views\ViewA;
use vsc\presentation\views\XmlView;

/**
 * @covers the public method XmlController::getDefaultView()
 */
class getDefaultView extends \PHPUnit_Framework_TestCase
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
