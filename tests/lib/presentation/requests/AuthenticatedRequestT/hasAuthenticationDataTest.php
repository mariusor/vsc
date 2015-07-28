<?php
namespace tests\lib\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequest::hasAuthenticationData()
 */
class hasAuthenticationData extends \PHPUnit_Framework_TestCase
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
	use AuthenticatedRequest {setAuthentication as public;}
}
