<?php
namespace tests\lib\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequestTrait::getAuthentication()
 */
class getAuthentication extends \BaseUnitTest
{
	public function testEmptyAtInitialize()
	{
		$o = new AuthenticatedRequest_underTest_getAuthentication();
		$this->assertEmpty($o->getAuthentication());
	}
}
class AuthenticatedRequest_underTest_getAuthentication {
	use AuthenticatedRequestTrait;
}
