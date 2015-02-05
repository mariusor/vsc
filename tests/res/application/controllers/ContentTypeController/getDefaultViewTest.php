<?php
namespace tests\res\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getDefaultView()
 */
class getDefaultView extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new ContentTypeController();
		$this->assertNull($o->getDefaultView());
	}
}
