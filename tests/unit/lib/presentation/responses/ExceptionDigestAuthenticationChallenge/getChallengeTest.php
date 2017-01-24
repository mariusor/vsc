<?php
namespace tests\lib\presentation\responses\ExceptionDigestAuthenticationChallenge;
use vsc\presentation\responses\ExceptionDigestAuthenticationChallenge;

/**
 * @covers \vsc\presentation\responses\ExceptionDigestAuthenticationChallenge::getChallenge()
 */
class getChallenge extends \BaseUnitTest
{
	public function testGetBasicChallenge()
	{
		$sMessage = 'test';
		$sRealm = 'unit-test';
		$sNonce = uniqid();
		$sOpaque = md5($sRealm);
		$o = new ExceptionDigestAuthenticationChallenge_underTest_getChallenge($sMessage, $sRealm, $sNonce);

		$sChallenge =<<<Start
Digest realm="{$sRealm}",qop="auth",nonce="{$sNonce}",opaque="{$sOpaque}"
Start;

		$this->assertEquals($sChallenge, $o->getChallenge());
	}
}

class ExceptionDigestAuthenticationChallenge_underTest_getChallenge extends ExceptionDigestAuthenticationChallenge {}
