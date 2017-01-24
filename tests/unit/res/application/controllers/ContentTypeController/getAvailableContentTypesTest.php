<?php
namespace tests\res\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getAvailableContentTypes()
 */
class getAvailableContentTypes extends \BaseUnitTest
{
	public function testUseless()
	{
		$o = new ContentTypeController();
		$this->assertNull($o->getAvailableContentTypes());
	}
}
