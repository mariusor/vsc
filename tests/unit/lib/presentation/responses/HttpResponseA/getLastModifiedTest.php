<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getLastModified()
 */
class getLastModified extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getLastModified()
	 * @covers \vsc\presentation\responses\HttpResponseA::setLastModified()
	 */
	public function testSetGetLastModified () {
		$state = new HttpResponseA_underTest_getLastModified();

		$this->assertNull($state->getLastModified());

		date_default_timezone_set('UTC');
		$testValue = date('Y-m-d');
		$state->setLastModified($testValue);
		$this->assertEquals($testValue, $state->getLastModified());
	}
}

class HttpResponseA_underTest_getLastModified extends HttpResponseA {}
