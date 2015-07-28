<?php
namespace tests\lib\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\AuthenticatedRequest;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequest::getAuthentication()
 */
class getAuthentication extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$o = new AuthenticatedRequest_underTest_getAuthentication();
		$this->assertEmpty($o->getAuthentication());
	}
}
class AuthenticatedRequest_underTest_getAuthentication {
	use AuthenticatedRequest;
}
