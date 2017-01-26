<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setCacheControl()
 */
class setCacheControl extends \BaseUnitTest
{
	public function testBasicSetCacheControl()
	{
		$o = new HttpResponseA_underTest_setCacheControl();
		$sTest = 'test';
		$o->setCacheControl($sTest);

		$this->assertEquals($sTest, $o->getCacheControl());
	}
}

class HttpResponseA_underTest_setCacheControl extends HttpResponseA {}
