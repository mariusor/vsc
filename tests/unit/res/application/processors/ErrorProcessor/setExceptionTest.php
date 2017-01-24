<?php
namespace tests\res\application\processors\ErrorProcessor;
use vsc\domain\models\EmptyModel;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\ExceptionError;

/**
 * @covers \vsc\application\processors\ErrorProcessor::setException()
 */
class setException extends \BaseUnitTest
{
	public function testSetErrorException ()
	{
		$Exception = new ExceptionError('test', 123);
		$o = new ErrorProcessor($Exception);

		$sMessage = uniqid('MESSAGE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$Exception = new ExceptionResponseError($sMessage, $iError);

		$o->setException($Exception);
		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $o->getModel());

		$this->assertEquals($sMessage, $o->getModel()->getMessage());
		$this->assertEquals($iError, $o->getModel()->getHttpStatus());
	}

	public function testSetNull ()
	{
		$o = new ErrorProcessor();
		$o->setException();
		$this->assertInstanceOf(EmptyModel::class, $o->getModel());
	}
}
