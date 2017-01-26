<?php
namespace tests\presentation\requests\ServerRequestTrait;
use vsc\infrastructure\Base;
use vsc\presentation\requests\AuthenticatedRequestTrait;
use vsc\presentation\requests\BasicHttpAuthentication;
use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers vsc\presentation\requests\ServerRequestTrait::loadAuthenticationHeaders()
 */
class loadAuthenticationHeadersTest extends \BaseUnitTest
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
	use ServerRequestTrait {loadAuthenticationHeaders as public;}
	use AuthenticatedRequestTrait;
}
