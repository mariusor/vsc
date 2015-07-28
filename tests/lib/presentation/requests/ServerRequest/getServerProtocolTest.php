<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\ServerRequest;

/**
 * @covers \vsc\presentation\requests\ServerRequest::getServerProtocol()
 */
class getServerProtocol extends \PHPUnit_Framework_TestCase
{
	public function testGetNullServerProtocol()
	{
		$_SERVER['SERVER_PROTOCOL'] = null;
		$o = new ServerRequest_underTest_getServerProtocol();
		$this->assertNull($o->getServerProtocol());
	}
}

class ServerRequest_underTest_getServerProtocol {
	use ServerRequest;
	use AuthenticatedRequest;
}
