<?php
namespace tests\lib\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequestT::hasAuthenticationData()
 */
class hasAuthenticationData extends \PHPUnit_Framework_TestCase
{
	public function testHasNoAuthentication () {
		$o = new HttpRequestA_underTest_hasAuthenticationData();
		$this->assertFalse($o->hasAuthenticationData());
	}

	public function testHasAuthentication () {
		$o = new HttpRequestA_underTest_hasAuthenticationData();
		$o->setAuthentication(new DigestHttpAuthentication('test'));
		$this->assertTrue($o->hasAuthenticationData());
	}
}

class HttpRequestA_underTest_hasAuthenticationData extends HttpRequestA {
	public function setAuthentication (HttpAuthenticationA $oAuth) {
		$this->oAuth = $oAuth;
	}
}
