<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::isLocal()
 */
class isLocalTest extends \PHPUnit_Framework_TestCase {
	public function testIsLocal() {
		$oUrl = new UrlParserA_underTest(__FILE__);
		$this->assertTrue($oUrl->isLocal());
	}

	public function testIsRemote() {
		$oUrl = new UrlParserA_underTest('google.com');
		$this->assertFalse($oUrl->isLocal());
	}

	public function testIsRemoteIP() {
		$oUrl = new UrlParserA_underTest('8.8.8.8');
		$this->assertFalse($oUrl->isLocal());
	}
}
