<?php
namespace tests\lib\presentation\responses\ExceptionResponseError;

/**
 * @covers \vsc\presentation\responses\ExceptionResponseError::getErrorCode()
 */
class getErrorCode extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
