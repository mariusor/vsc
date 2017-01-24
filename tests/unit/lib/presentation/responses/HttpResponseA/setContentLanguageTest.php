<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setContentLanguage()
 */
class setContentLanguage extends \BaseUnitTest
{
	public function testBasicSetContentLanguage()
	{
		$o = new HttpResponseA_underTest_setContentLanguage();
		$sTest = 'test';
		$o->setContentLanguage($sTest);

		$this->assertEquals($sTest, $o->getContentLanguage());
	}
}

class HttpResponseA_underTest_setContentLanguage extends HttpResponseA {}
