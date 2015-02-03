<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasAuthenticationData()
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
	public function setAuthentication ($oAuth) {
		$this->oAuth = $oAuth;
	}
}
