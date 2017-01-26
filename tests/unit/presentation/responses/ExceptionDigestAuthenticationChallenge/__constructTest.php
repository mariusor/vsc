<?php
namespace tests\presentation\responses\ExceptionDigestAuthenticationChallenge;
use vsc\presentation\responses\ExceptionDigestAuthenticationChallenge;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionDigestAuthenticationChallenge::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testGetBasicChallenge()
	{
		$sMessage = 'test';
		$sRealm = 'unit-test';
		$sNonce = uniqid();
		$o = new ExceptionDigestAuthenticationChallenge_underTest___construct($sMessage, $sRealm, $sNonce);

		$this->assertEquals($sMessage, $o->getMessage());
		$this->assertEquals(HttpResponseType::NOT_AUTHORIZED, $o->getErrorCode());
	}
}

class ExceptionDigestAuthenticationChallenge_underTest___construct extends ExceptionDigestAuthenticationChallenge {}
