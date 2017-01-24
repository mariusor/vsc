<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getLocation()
 */
class getLocation extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpResponseA_underTest_setLocation();
		$this->assertNull($o->getLocation());
	}
}

class HttpResponseA_underTest_getLocation extends HttpResponseA {}
