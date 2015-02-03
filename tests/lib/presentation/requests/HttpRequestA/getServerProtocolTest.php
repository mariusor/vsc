<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getServerProtocol()
 */
class getServerProtocol extends \PHPUnit_Framework_TestCase
{
	public function testGetNullServerProtocol()
	{
		$_SERVER['SERVER_PROTOCOL'] = null;
		$o = new HttpRequestA_underTest_getServerProtocol();
		$this->assertNull($o->getServerProtocol());
	}
}

class HttpRequestA_underTest_getServerProtocol extends HttpRequestA {}
