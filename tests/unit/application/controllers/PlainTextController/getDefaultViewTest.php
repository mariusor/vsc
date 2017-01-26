<?php
namespace tests\application\controllers\PlainTextController;
use vsc\application\controllers\PlainTextController;
use vsc\presentation\views\PlainTextView;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\controllers\PlainTextController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testBasicGetDefaultView()
	{
		$s = new PlainTextController_underTest_getDefaultView();
		$this->assertInstanceOf(PlainTextView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}

class PlainTextController_underTest_getDefaultView extends PlainTextController {
}
