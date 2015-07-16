<?php
namespace res\presentation\requests\DigestHttpAuthentication;

use vsc\presentation\requests\DigestHttpAuthentication;
use vsc\presentation\requests\HttpRequestTypes;

/**
 * Class __constructTest
 * @package res\presentation\requests\DigestHttpAuthentication
 * @covers \vsc\presentation\requests\DigestHttpAuthentication::__construct()
 */
class __constructTest extends \PHPUnit_Framework_TestCase {

	public function test__construct() {
		$realm = 'testrealm@Whost.com';
		$user = 'Mufasa';
		$nonce = 'dcd98b7102dd2f0e8b11d0f600bfb0c093';
		$uri = '/dir/index.html';
		$cnonce = '0a4f113b';
		$response = '6629fae49393a05397450978507c4ef1';
		$opaque = '5ccc069c403ebaf9f0171e9517f40e41';
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

		$o = new DigestHttpAuthentication($sDigest);
		$this->assertEquals($user, $o->getUser());
		$this->assertNull($o->getPassword()); // this method should be removed
	}
}

