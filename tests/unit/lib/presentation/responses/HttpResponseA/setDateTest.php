<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setDate()
 */
class setDate extends \BaseUnitTest
{
	public function testBasicSetDate()
	{
		$o = new HttpResponseA_underTest_setDate();
		$sTest = 'test';
		$o->setDate($sTest);

		$this->assertEquals($sTest, $o->getDate());
	}
}

class HttpResponseA_underTest_setDate extends HttpResponseA {}
