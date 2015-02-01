<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasAuthenticationData()
 */
class hasAuthenticationData extends \PHPUnit_Framework_TestCase
{
	public function testHasBasicAuthentication () {
		$o = new HttpRequestA_underTest_hasAuthenticationData();
		$o->hasAuthenticationData();
	}
	public function testHasDigestAuthentication () {
		$this->markTestIncomplete(" ... ");
	}
	public function testHasNoAuthentication () {
		$this->markTestIncomplete(" ... ");
	}
}

class HttpRequestA_underTest_hasAuthenticationData extends HttpRequestA {}
