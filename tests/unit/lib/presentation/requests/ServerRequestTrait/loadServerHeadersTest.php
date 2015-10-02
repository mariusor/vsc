<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers vsc\presentation\requests\ServerRequestTrait::loadServerHeaders()
 */
class loadServerHeadersTest extends \PHPUnit_Framework_TestCase
{
	public function testBasicLoad() {
		$aServer = [
			'SERVER_PROTOCOL' => 'HTTP/1.1',
			'SERVER_NAME' => uniqid('test:'),
		];

		$o = new ServerRequest_underTest_loadServerHeaders();
		$o->loadServerHeaders($aServer);

		$this->assertEquals($aServer['SERVER_NAME'], $o->getServerName());
		$this->assertEquals($aServer['SERVER_PROTOCOL'], $o->getServerProtocol());
	}
}

class ServerRequest_underTest_loadServerHeaders {
	use ServerRequestTrait {loadServerHeaders as public;}

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		return true;
	}
}
