<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use fixtures\presentation\responses\ResponseFixture;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::addHeader()
 */
class addHeader extends \PHPUnit_Framework_TestCase
{
	public function testAddHeader() {
		$state = new ResponseFixture();

		$testHeader = 'Location';
		$testValue = 'http://ana.are.mere';

		$state->addHeader($testHeader, $testValue);
		$this->assertEquals($testValue, $state->getHeader($testHeader));

		$testHeader = 'X-WWW-Authentication';
		$testNonce = uniqid('nonce:');
		$testValue =<<<BEGIN
Digest username="test",
realm="testrealm",
nonce="{$testNonce}",
uri="http://ana.are.mere",
cnonce="",
nc=00000001,
qop="auth",
response=""
BEGIN;

		$state->addHeader($testHeader, $testValue);
		$this->assertEquals($testValue, $state->getHeader($testHeader));
		$this->assertNull($state->getHeader(uniqid('hdr:')));
	}
}
