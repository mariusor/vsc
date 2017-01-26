<?php
namespace tests\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new ContentTypeController();
		$this->assertNull($o->getDefaultView());
	}
}
