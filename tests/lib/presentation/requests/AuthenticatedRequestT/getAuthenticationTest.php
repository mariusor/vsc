<?php
namespace tests\lib\presentation\requests\AuthenticatedRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\AuthenticatedRequestT::getAuthentication()
 */
class getAuthentication extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$o = new HttpRequestA_underTest_getAuthentication();
		$this->assertEmpty($o->getAuthentication());
	}
}
class HttpRequestA_underTest_getAuthentication extends HttpRequestA {}
