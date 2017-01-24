<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentLocation()
 */
class setContentLocation extends \BaseUnitTest
{
	public function testBasicSetContentLocation()
	{
		$o = new HttpResponseA_underTest_setContentLocation();
		$sTest = 'test';
		$o->setContentLocation($sTest);

		$this->assertEquals($sTest, $o->getContentLocation());
	}
}

class HttpResponseA_underTest_setContentLocation extends HttpResponseA {}
