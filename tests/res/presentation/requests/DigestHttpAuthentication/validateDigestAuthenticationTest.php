<?php
namespace res\presentation\requests\DigestHttpAuthentication;

use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpRequestTypes;

/**
 * Class validateDigestAuthenticationTest
 * @package res\presentation\requests\DigestHttpAuthentication
 * @covers \vsc\presentation\requests\DigestHttpAuthentication::validateDigestAuthentication()
 */
class validateDigestAuthenticationTest extends \PHPUnit_Framework_TestCase {
	public function test__ExampleFromRFC() {
		$realm = 'testrealm@host.com';
		$user = 'Mufasa';
		$nonce = 'dcd98b7102dd2f0e8b11d0f600bfb0c093';
		$uri = '/dir/index.html';
		$cnonce = '0a4f113b';
		$response = '6629fae49393a05397450978507c4ef1';
		$opaque = '5ccc069c403ebaf9f0171e9517f40e41';
		$password = 'Circle Of Life';
		$sDigest =<<<START
			username="{$user}",
			realm="{$realm}",
			nonce="{$nonce}",
			uri="{$uri}",
			qop=auth,
			nc=00000001,
			cnonce="{$cnonce}",
			response="{$response}",
			opaque="{$opaque}"
START;

		$o = new DigestHttpAuthentication($sDigest, HttpRequestTypes::GET);
		$this->assertEquals($user, $o->getUser());
		$this->assertTrue($o->validateDigestAuthentication($password, $realm));
	}
}
