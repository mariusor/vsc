<?php
namespace tests\lib\presentation\responses\ExceptionResponseError;

/**
 * @covers the public method ExceptionResponseError::getErrorCode()
 */
class getErrorCode extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
