<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequest;

/**
 * Class loadServerHeadersTest
 * @package tests\lib\presentation\requests\ServerRequest
 * @covers vsc\presentation\requests\ServerRequest::loadServerHeaders()
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
	use ServerRequest {loadServerHeaders as public;}

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		return true;
	}
}
