<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getServerProtocol()
 */
class getServerProtocol extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetServerProtocol()
	{
		$_SERVER['SERVER_PROTOCOL'] = '1.0';
		$o = new HttpResponseA_underTest_getServerProtocol();

		$this->assertEquals($_SERVER['SERVER_PROTOCOL'], $o->getServerProtocol());
	}
}

class HttpResponseA_underTest_getServerProtocol extends HttpResponseA {}