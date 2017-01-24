<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getContentLanguage()
 */
class getContentLanguage extends \BaseUnitTest
{
	/**
	 * @covers \vsc\presentation\responses\HttpResponseA::getContentLanguage()
	 * @covers \vsc\presentation\responses\HttpResponseA::setContentLanguage()
	 */
	public function testSetGetContentLanguage ()
	{
		$state = new HttpResponseA_underTest_getContentLanguage();

		$this->assertNull($state->getContentLanguage());

		$testValue = 'ro';
		$state->setContentLanguage($testValue);
		$this->assertEquals($testValue, $state->getContentLanguage());
	}
}
class HttpResponseA_underTest_getContentLanguage extends HttpResponseA {}
