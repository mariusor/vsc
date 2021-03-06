<?php
namespace tests\application\controllers\RssController;
use vsc\presentation\views\RssView;
use vsc\presentation\views\ViewA;
use vsc\application\controllers\RssController;

/**
 * @covers \vsc\application\controllers\RssController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testBasicGetDefaultView()
	{
		$s = new RssController_underTest_getDefaultView();
		$this->assertInstanceOf(RssView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}

class RssController_underTest_getDefaultView extends RssController {
}
