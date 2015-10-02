<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers vsc\presentation\requests\ServerRequestTrait::loadAcceptHeaders()
 */
class loadAcceptHeadersTest extends \PHPUnit_Framework_TestCase
{
	public function testBasicLoad() {
		$aServer = [
			'HTTP_ACCEPT' => uniqid('accept:'),
			'HTTP_ACCEPT_LANGUAGE' => uniqid('lang:'),
			'HTTP_ACCEPT_ENCODING' => uniqid('enc:'),
			'HTTP_ACCEPT_CHARSET' => uniqid('charset:'),
		];

		$o = new ServerRequest_underTest_loadAcceptHeaders();
		$o->loadAcceptHeaders($aServer);

		// verify against array of values
		$this->assertEquals([$aServer['HTTP_ACCEPT']], $o->getHttpAccept());
		$this->assertEquals([$aServer['HTTP_ACCEPT_LANGUAGE']], $o->getHttpAcceptLanguage());
		$this->assertEquals([$aServer['HTTP_ACCEPT_ENCODING']], $o->getHttpAcceptEncoding());
		$this->assertEquals([$aServer['HTTP_ACCEPT_CHARSET']], $o->getHttpAcceptCharset());
	}
}

class ServerRequest_underTest_loadAcceptHeaders {
	use ServerRequestTrait {loadAcceptHeaders as public;}

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		return true;
	}
}
