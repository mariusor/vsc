<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentDisposition()
 */
class setContentDisposition extends \BaseUnitTest
{
	public function testBasicSetContentDisposition()
	{
		$o = new HttpResponseA_underTest_setContentDisposition();
		$sTest = 'test';
		$o->setContentDisposition($sTest);

		$this->assertEquals($sTest, $o->getContentDisposition());
	}
}

class HttpResponseA_underTest_setContentDisposition extends HttpResponseA {}
