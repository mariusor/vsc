<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setExpires()
 */
class setExpires extends \BaseUnitTest
{
	public function testBasicSetExpires()
	{
		$o = new HttpResponseA_underTest_setExpires();
		$sTest = 'test';
		$o->setExpires($sTest);

		$this->assertEquals($sTest, $o->getExpires());
	}
}

class HttpResponseA_underTest_setExpires extends HttpResponseA {}
