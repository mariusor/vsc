<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getDate()
 */
class getDate extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getDate()
	 * @covers \vsc\presentation\responses\HttpResponseA::setDate()
	 */
	public function testSetGetDate ()
	{
		$state = new HttpResponseA_underTest_getDate();

		$this->assertNull($state->getDate());

		date_default_timezone_set('UTC');
		$testValue = date('Y-m-d');
		$state->setDate($testValue);
		$this->assertEquals($testValue, $state->getDate());
	}
}

class HttpResponseA_underTest_getDate extends HttpResponseA {}
