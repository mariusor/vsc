<?php
namespace tests\res\application\controllers\JsonController;
use vsc\application\controllers\JsonController;
use vsc\presentation\views\JsonView;
use vsc\presentation\views\ViewA;

/**
 * @covers \vsc\application\controllers\JsonController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testBasicGetDefaultView()
	{
		$s = new JsonController();
		$this->assertInstanceOf(JsonView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}
