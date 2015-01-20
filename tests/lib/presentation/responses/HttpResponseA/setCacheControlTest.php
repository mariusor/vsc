<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setCacheControl()
 */
class setCacheControl extends \PHPUnit_Framework_TestCase
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