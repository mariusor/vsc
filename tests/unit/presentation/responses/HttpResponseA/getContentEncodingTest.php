<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentEncoding()
 */
class getContentEncoding extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentEncoding()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentEncoding()
	 */
	public function testSetGetContentEncoding ()
	{
		$state = new HttpResponseA_underTest_getContentEncoding();

		$this->assertNull($state->getContentEncoding());

		$testValue = 'UTF-8';
		$state->setContentEncoding($testValue);
		$this->assertEquals($testValue, $state->getContentEncoding());
	}
}

class HttpResponseA_underTest_getContentEncoding extends HttpResponseA {}
