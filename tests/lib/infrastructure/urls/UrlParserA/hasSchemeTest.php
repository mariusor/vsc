<?php

namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/** @covers \vsc\infrastructure\urls\UrlParserA::hasScheme */
class hasSchemeTest extends \PHPUnit_Framework_TestCase {

	public function testHasSchemeTrue () {
		$oUrl = new UrlParserA_underTest ('file://' . __FILE__);
		$this->assertTrue ($oUrl->hasScheme());

		$oUrl = new UrlParserA_underTest ('http://localhost');
		$this->assertTrue ($oUrl->hasScheme());

		$oUrl = new UrlParserA_underTest ('https://8.8.8.8');
		$this->assertTrue ($oUrl->hasScheme());
	}

	public function testHasSchemeFalse () {
		//$this->markTestSkipped('Need to implement hasScheme vs. displayScheme');
		$oUrl = new UrlParserA_underTest('//localhost');
		$this->assertFalse ($oUrl->hasScheme());

		$oUrl = new UrlParserA_underTest(__FILE__);
		$this->assertFalse ($oUrl->hasScheme());

		$oUrl = new UrlParserA_underTest('192.168.1.254');
		$this->assertFalse ($oUrl->hasScheme());
	}
}

