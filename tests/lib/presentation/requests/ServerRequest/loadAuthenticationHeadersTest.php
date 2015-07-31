<?php
namespace tests\lib\presentation\requests\ServerRequest;
use vsc\infrastructure\Base;
use vsc\presentation\requests\AuthenticatedRequest;
use vsc\presentation\requests\BasicHttpAuthentication;
use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequest;

/**
 * Class loadAuthenticationHeadersTest
 * @package tests\lib\presentation\requests\ServerRequest
 * @covers vsc\presentation\requests\ServerRequest::loadAuthenticationHeaders()
 */
class loadAuthenticationHeadersTest extends \PHPUnit_Framework_TestCase
{
	public function testLoadWithDigestAuthentication() {
		$aServer = [
			'PHP_AUTH_DIGEST' => uniqid('digest:'),
			'REQUEST_METHOD' => 'GET',
		];

		$o = new ServerRequest_underTest_loadAuthenticationHeaders();
		$o->loadAuthenticationHeaders($aServer);

		$auth = $o->getAuthentication();
		$this->assertInstanceOf(DigestHttpAuthentication::class, $auth);
	}

	public function testLoadWithBasicAuthentication() {
		$aServer = [
			'PHP_AUTH_USER' => 'Allad1n',
			'PHP_AUTH_PW' => uniqid('password:'),
		];

		$o = new ServerRequest_underTest_loadAuthenticationHeaders();
		$o->loadAuthenticationHeaders($aServer);

		$auth = $o->getAuthentication();
		$this->assertInstanceOf(BasicHttpAuthentication::class, $auth);
		$this->assertEquals($aServer['PHP_AUTH_USER'], $auth->getUser());
		$this->assertEquals($aServer['PHP_AUTH_PW'], $auth->getPassword());
	}
}

class ServerRequest_underTest_loadAuthenticationHeaders {
	use ServerRequest {loadAuthenticationHeaders as public;}
	use AuthenticatedRequest;
}
