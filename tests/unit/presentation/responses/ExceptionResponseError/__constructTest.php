<?php
namespace tests\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseError::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasicInitialization()
	{
		$sMessage = uniqid('test:');
		$iCode = HttpResponseType::INTERNAL_ERROR;

		$o = new ExceptionResponseError($sMessage, $iCode);
		$this->assertEquals($sMessage, $o->getMessage());
		$this->assertEquals($iCode, $o->getErrorCode());
	}
}
