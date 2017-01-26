<?php
namespace tests\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\HttpAuthenticationA::getUser()
 */
class getUser extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpAuthenticationA_underTest_getUser();
		$this->assertEmpty($o->getUser());
	}
}

class HttpAuthenticationA_underTest_getUser extends HttpAuthenticationA {}
