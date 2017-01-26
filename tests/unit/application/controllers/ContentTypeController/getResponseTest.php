<?php
namespace tests\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;
use vsc\presentation\responses\HttpResponse;
use vsc\infrastructure\vsc;
use vsc\application\processors\EmptyProcessor;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getResponse()
 */
class getResponse extends \BaseUnitTest
{
	public function testBasicGetResponse()
	{
		$o = new ContentTypeController();

		$p = new EmptyProcessor();
		$r = $o->getResponse(vsc::getEnv()->getHttpRequest(), $p);

		$this->assertNull($r);
	}
}
