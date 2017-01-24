<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getExpires()
 */
class getExpires extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getExpires()
	 * @covers \vsc\presentation\responses\HttpResponseA::setExpires()
	 */
	public function testSetGetExpires ()
	{
		$state = new HttpResponseA_underTest_getExpires();

		$this->assertNull($state->getExpires());

		date_default_timezone_set('UTC');
		$testValue = date('Y-m-d');
		$state->setExpires($testValue);
		$this->assertEquals($testValue, $state->getExpires());
	}
}

class HttpResponseA_underTest_getExpires extends HttpResponseA {}
