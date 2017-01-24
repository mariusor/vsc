<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setETag()
 */
class setETag extends \BaseUnitTest
{
	public function testBasicSetETag()
	{
		$o = new HttpResponseA_underTest_setExpires();
		$sTest = 'test';
		$o->setETag($sTest);

		$this->assertEquals($sTest, $o->getETag());
	}
}

class HttpResponseA_underTest_setETag extends HttpResponseA {}
