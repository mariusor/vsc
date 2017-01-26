<?php
namespace tests\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;
use vsc\application\processors\EmptyProcessor;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getErrorResponse()
 */
class getErrorResponse extends \BaseUnitTest
{
	public function testGetErrorResponse()
	{
		$o = new ContentTypeController();

		$p = new EmptyProcessor();
		$r = $o->getResponse(vsc::getEnv()->getHttpRequest(), $p);

		$this->assertNull($r);
	}
}
