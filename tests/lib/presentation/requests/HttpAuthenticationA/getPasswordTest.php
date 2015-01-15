<?php
namespace tests\lib\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\HttpAuthenticationA::getPassword()
 */
class getPassword extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpAuthenticationA_underTest_getPassword();
		$this->assertEmpty($o->getPassword());
	}
}

class HttpAuthenticationA_underTest_getPassword extends HttpAuthenticationA {}
