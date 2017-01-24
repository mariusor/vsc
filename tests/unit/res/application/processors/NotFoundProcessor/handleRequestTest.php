<?php
namespace tests\res\application\processors\NotFoundProcessor;
use vsc\application\processors\NotFoundProcessor;
use vsc\infrastructure\vsc;
use vsc\domain\models\ErrorModel;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\application\processors\NotFoundProcessor::handleRequest()
 */
class handleRequest extends \BaseUnitTest
{
	public function testBasicHandleRequest()
	{
		$o = new NotFoundProcessor();

		$oModel = $o->handleRequest(vsc::getEnv()->getHttpRequest());
		$this->assertInstanceOf(ErrorModel::class, $oModel);
		$this->assertInstanceOf(ExceptionResponseError::class, $oModel->getException());
		$this->assertEquals(HttpResponseType::NOT_FOUND, $oModel->getException()->getErrorCode());
	}
}
