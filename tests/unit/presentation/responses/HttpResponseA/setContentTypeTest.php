<?php
namespace tests\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentType()
 */
class setContentType extends \BaseUnitTest
{
	public function testBasicSetContentType()
	{
		$o = new HttpResponseA_underTest_setContentType();
		$sTest = 'test';
		$o->setContentType($sTest);

		$this->assertEquals($sTest, $o->getContentType());
	}
}

class HttpResponseA_underTest_setContentType extends HttpResponseA {}
