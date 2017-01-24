<?php
namespace tests\lib\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequestTrait::hasAuthenticationData()
 */
class hasAuthenticationData extends \BaseUnitTest
{
	public function testHasNoAuthentication () {
		$o = new AuthenticatedRequest_underTest_hasAuthenticationData();
		$this->assertFalse($o->hasAuthenticationData());
	}

	public function testHasAuthentication () {
		$o = new AuthenticatedRequest_underTest_hasAuthenticationData();
		$o->setAuthentication(new DigestHttpAuthentication('test'));
		$this->assertTrue($o->hasAuthenticationData());
	}
}

class AuthenticatedRequest_underTest_hasAuthenticationData {
	use AuthenticatedRequestTrait {setAuthentication as public;}
}
