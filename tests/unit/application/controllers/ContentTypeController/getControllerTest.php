<?php
namespace tests\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getController()
 */
class getController extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new ContentTypeController();
		$this->assertNull($o->getController());
	}
}
