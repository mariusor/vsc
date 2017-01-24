<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentLocation()
 */
class getContentLocation extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentLocation()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentLocation()
	 */
	public function testSetGetContentLocation ()
	{
		$state = new HttpResponseA_underTest_getContentLocation ();

		$this->assertNull($state->getContentLocation());

		$testValue = 'http://example.com/test';
		$state->setContentLocation($testValue);
		$this->assertEquals($testValue, $state->getContentLocation());
	}
}

class HttpResponseA_underTest_getContentLocation extends HttpResponseA {}
