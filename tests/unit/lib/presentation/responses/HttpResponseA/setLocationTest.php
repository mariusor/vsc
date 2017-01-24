<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setLocation()
 */
class setLocation extends \BaseUnitTest
{
	public function testSetGetLocation () {
		$state = new HttpResponseA_underTest_setLocation();

		$this->assertNull($state->getLocation());

		$sLocation = '/';

		$state->setLocation($sLocation);
		$this->assertEquals($sLocation, $state->getLocation());

		$testValue = 'http://ana.are.mere';
		$state->setLocation($testValue);
		$this->assertEquals($testValue, $state->getLocation());
	}
}

class HttpResponseA_underTest_setLocation extends HttpResponseA {}
