<?php
namespace tests\res\application\controllers\JsonController;
use vsc\application\controllers\JsonController;
use vsc\presentation\views\JsonView;
use vsc\presentation\views\ViewA;

/**
 * @covers the public method JsonController::getDefaultView()
 */
class getDefaultView extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetDefaultView()
	{
		$s = new JsonController();
		$this->assertInstanceOf(JsonView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}
}
