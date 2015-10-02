<?php
namespace tests\res\application\controllers\ContentTypeController;
use vsc\application\controllers\ContentTypeController;
use vsc\application\processors\EmptyProcessor;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\controllers\ContentTypeController::getErrorResponse()
 */
class getErrorResponse extends \PHPUnit_Framework_TestCase
{
	public function testGetErrorResponse()
	{
		$o = new ContentTypeController();

		$p = new EmptyProcessor();
		$r = $o->getResponse(vsc::getEnv()->getHttpRequest(), $p);

		$this->assertNull($r);
	}
}
