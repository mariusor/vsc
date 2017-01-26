<?php
namespace tests\application\processors\ErrorProcessor;
use vsc\ExceptionError;
use vsc\application\processors\ErrorProcessor;
use vsc\presentation\responses\HttpResponseType;
use vsc\application\sitemaps\ClassMap;
use vsc\presentation\responses\ExceptionResponseError;

/**
 * @covers \vsc\application\processors\ErrorProcessor::getModel()
 */
class getModel extends \BaseUnitTest
{
	public function testGetModel ()
	{
		$Exception = new ExceptionError('test', 123);
		$o = new ErrorProcessor($Exception);

		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $o->getModel());

		$this->assertEquals('test', $o->getModel()->getMessage());
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $o->getModel()->getHttpStatus());
	}

	public function testGetException () {
		$Exception = new ExceptionError('test', 123);
		$o = new ErrorProcessor($Exception);

		$sMessage = uniqid('MESSAGE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$o->setException(new ExceptionResponseError($sMessage, $iError));

		$oModel = $o->getModel();
		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $oModel);

		$Exception = $oModel->getException();
		$this->assertInstanceOf(ExceptionResponseError::class, $Exception);
		$this->assertInstanceOf(\vsc\presentation\responses\ExceptionResponse::class, $Exception);
		$this->assertInstanceOf(\vsc\presentation\ExceptionPresentation::class, $Exception);
	}
}
