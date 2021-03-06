<?php
namespace tests\presentation\responses\ExceptionAuthenticationNeeded;
use vsc\presentation\responses\ExceptionAuthenticationNeeded;

/**
 * @covers \vsc\presentation\responses\ExceptionAuthenticationNeeded::getChallenge()
 */
class getChallenge extends \BaseUnitTest
{
	public function testGetBasicChallenge()
	{
		$sMessage = 'test';
		$sRealm = 'unit-test';
		$o = new ExceptionAuthenticationNeeded_underTest_getChallenge($sMessage, $sRealm);

		$sChallenge =<<<Start
Basic realm="{$sRealm}"
Start;

		$this->assertEquals($sChallenge, $o->getChallenge());
	}
}

class ExceptionAuthenticationNeeded_underTest_getChallenge extends ExceptionAuthenticationNeeded {}
