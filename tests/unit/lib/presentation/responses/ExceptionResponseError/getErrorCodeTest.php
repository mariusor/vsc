<?php
namespace tests\lib\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\ExceptionResponseError;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseError::getErrorCode()
 */
class getErrorCode extends \PHPUnit_Framework_TestCase
{
	public function testBasticGetErrorCode()
	{
		$o = new ExceptionResponseError_underTest_getErrorCode(HttpResponseType::INTERNAL_ERROR);
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $o->getErrorCode());
	}
}

class ExceptionResponseError_underTest_getErrorCode extends ExceptionResponseError {
	public function __construct ($iStatus, $sMessage = 'test') {
		parent::__construct($sMessage, $iStatus);
	}
}
