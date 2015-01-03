<?php
namespace tests\res\application\processors\ErrorProcessor;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\ExceptionError;

/**
 * @covers \vsc\application\processors\ErrorProcessor::setException()
 */
class setException extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetException ()
	{
		$Exception = new ExceptionError('test', 123);
		$o = new ErrorProcessor($Exception);

		$oMap = new ClassMap(ErrorProcessor::class, '.*');

		$sMessage = uniqid('MESSAGE:');
		$sCode = uniqid('CODE:');
		$iError = HttpResponseType::CLIENT_ERROR;
		$Exception = new ExceptionResponseError($sMessage, $iError);

		$o->setException($Exception);
		$this->assertInstanceOf(\vsc\domain\models\ErrorModel::class, $o->getModel());

		$this->assertEquals($sMessage, $o->getModel()->getMessage());
		$this->assertEquals($iError, $o->getModel()->getHttpStatus());
	}
}
