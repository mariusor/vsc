<?php
namespace tests\lib\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequest::setAuthentication()
 */
class setAuthentication extends \PHPUnit_Framework_TestCase
{
	public function testSetNoAuthentication () {
		$value = new HttpAuthenticationA_underTest_setAuthentication();
		$o = new AuthenticatedRequest_underTest_setAuthentication();
		$o->setAuthentication($value);
		$this->assertSame($value, $o->getAuthentication());
	}
}

class HttpAuthenticationA_underTest_setAuthentication extends HttpAuthenticationA {}

class AuthenticatedRequest_underTest_setAuthentication {
	use AuthenticatedRequest {setAuthentication as public;}
}
