<?php
namespace tests\presentation\responses\ExceptionAuthenticationNeeded;
use vsc\presentation\responses\ExceptionAuthenticationNeeded;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\ExceptionAuthenticationNeeded::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testGetBasicChallenge()
	{
		$sMessage = 'test';
		$sRealm = 'unit-test';
		$o = new ExceptionAuthenticationNeeded_underTest___construct($sMessage, $sRealm);

		$this->assertEquals($sMessage, $o->getMessage());
		$this->assertEquals(HttpResponseType::NOT_AUTHORIZED, $o->getErrorCode());
	}
}

class ExceptionAuthenticationNeeded_underTest___construct extends ExceptionAuthenticationNeeded {}
