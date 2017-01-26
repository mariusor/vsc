<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentLength()
 */
class setContentLength extends \BaseUnitTest
{
	public function testBasicSetContentLength()
	{
		$o = new HttpResponseA_underTest_setContentLength();
		$sTest = 'test';
		$o->setContentLength($sTest);

		$this->assertEquals($sTest, $o->getContentLength());
	}
}

class HttpResponseA_underTest_setContentLength extends HttpResponseA {}
