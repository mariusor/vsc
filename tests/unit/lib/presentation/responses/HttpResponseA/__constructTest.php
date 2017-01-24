<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testBasicSetContentType()
	{
		$o = new HttpResponseA_underTest___construct();
		$this->assertEmpty($o->getServerProtocol());
	}
}

class HttpResponseA_underTest___construct extends HttpResponseA {}
