<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentDisposition()
 */
class getContentDisposition extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentDisposition()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentDisposition()
	 */
	public function testSetGetContentDisposition ()
	{
		$state = new HttpResponseA_underTest_getContentDisposition();

		$this->assertNull($state->getContentDisposition());

		$testValue = uniqid('test');
		$state->setContentDisposition($testValue);
		$this->assertEquals($testValue, $state->getContentDisposition());
	}
}

class HttpResponseA_underTest_getContentDisposition extends HttpResponseA {}
