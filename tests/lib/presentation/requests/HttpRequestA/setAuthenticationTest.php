<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::setAuthentication()
 */
class setAuthentication extends \PHPUnit_Framework_TestCase
{
	public function testSetNoAuthentication () {
		$value = new HttpAuthenticationA_underTest_setAuthentication();
		$o = new HttpRequestA_underTest_setAuthentication();
		$o->setAuthentication($value);
		$this->assertSame($value, $o->getAuthentication());
	}
}

class HttpAuthenticationA_underTest_setAuthentication extends HttpAuthenticationA {}

class HttpRequestA_underTest_setAuthentication extends HttpRequestA {
	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		return parent::setAuthentication($oHttpAuthentication);
	}
}
