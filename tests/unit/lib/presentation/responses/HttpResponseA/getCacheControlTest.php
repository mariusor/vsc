<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getCacheControl()
 */
class getCacheControl extends \PHPUnit_Framework_TestCase
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getCacheControl()
	 * @covers \vsc\presentation\responses\HttpResponseA::setCacheControl()
	 */
	public function testSetGetCacheControl ()
	{
		$state = new HttpResponseA_underTest_getCacheControl();

		$this->assertNull($state->getCacheControl());

		$testValue = 'Must-Revalidate';
		$state->setCacheControl($testValue);
		$this->assertEquals($testValue, $state->getCacheControl());
	}
}

class HttpResponseA_underTest_getCacheControl extends HttpResponseA {}
