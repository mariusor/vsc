<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentLength()
 */
class getContentLength extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentLength()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentLength()
	 */
	public function testSetGetContentLength ()
	{
		$state = new HttpResponseA_underTest_getContentLength();

		$this->assertNull($state->getContentLength());

		$testValue = 666;
		$state->setContentLength($testValue);
		$this->assertEquals($testValue, $state->getContentLength());
	}
}

class HttpResponseA_underTest_getContentLength extends HttpResponseA {}
