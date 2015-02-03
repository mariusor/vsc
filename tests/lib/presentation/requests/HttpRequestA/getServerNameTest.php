<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getServerName()
 */
class getServerName extends \PHPUnit_Framework_TestCase
{
	public function testGetNullServerName()
	{
		$_SERVER['SERVER_NAME'] = null;
		$o = new HttpRequestA_underTest_getServerName();
		$this->assertNull($o->getServerName());
	}
}

class HttpRequestA_underTest_getServerName extends HttpRequestA {}
