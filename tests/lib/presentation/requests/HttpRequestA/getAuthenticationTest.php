<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getAuthentication()
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