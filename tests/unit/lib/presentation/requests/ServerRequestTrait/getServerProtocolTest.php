<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getServerProtocol()
 */
class getServerProtocol extends \BaseUnitTest
{
	public function testGetNullServerProtocol()
	{
		$_SERVER['SERVER_PROTOCOL'] = null;
		$o = new ServerRequest_underTest_getServerProtocol();
		$this->assertNull($o->getServerProtocol());
	}
}

class ServerRequest_underTest_getServerProtocol {
	use ServerRequestTrait;
	use AuthenticatedRequestTrait;
}
