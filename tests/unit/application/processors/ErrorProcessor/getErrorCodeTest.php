<?php
namespace tests\application\processors\ErrorProcessor;
use vsc\application\processors\ErrorProcessor;
use vsc\Exception;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\application\processors\ErrorProcessor::getErrorCode()
 */
class getErrorCode extends \BaseUnitTest
{
	public function testGetDefaultErrorCode()
	{
		$e = new Exception('test');
		$o = new ErrorProcessor($e);

		$this->assertEquals(500, $o->getErrorCode());
	}

	public function testGetExceptionResponseErrorDefaultErrorCode()
	{
		$e = new ExceptionResponseError('test');
		$o = new ErrorProcessor($e);

		$this->assertEquals(500, $o->getErrorCode());
	}

	public function testGetExceptionResponseErrorVariousErrorCodes()
	{
		$oResponseTypeMirror = new \ReflectionClass(HttpResponseType::class);
		$aStatusProperties = $oResponseTypeMirror->getStaticProperties();

		$aStatuses = $aStatusProperties['aStatusList'];

		foreach ($aStatuses as $iStatus => $sResponseStatus) {
			$e = new ExceptionResponseError('test', $iStatus);
			$o = new ErrorProcessor($e);
			$this->assertEquals($iStatus, $o->getErrorCode());
		}

	}
}
