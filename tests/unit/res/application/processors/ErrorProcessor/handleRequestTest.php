<?php
namespace tests\res\application\processors\ErrorProcessor;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\application\processors\ErrorProcessor;
use vsc\presentation\responses\HttpResponseType;
use vsc\infrastructure\vsc;
use vsc\domain\models\ErrorModel;

/**
 * @covers \vsc\application\processors\ErrorProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testBasicHandleRequest()
	{
		$e = new ExceptionResponseError('test', HttpResponseType::NO_CONTENT);
		$o = new ErrorProcessor($e);

		$oModel = $o->handleRequest(vsc::getEnv()->getHttpRequest());
		$this->assertInstanceOf(ErrorModel::class, $oModel);
		$this->assertInstanceOf(ExceptionResponseError::class, $oModel->getException());
		$this->assertEquals(HttpResponseType::NO_CONTENT, $oModel->getException()->getErrorCode());
	}
}
