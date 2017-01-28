<?php
namespace tests\infrastructure\urls\UrlParserA;
use mocks\infrastructure\urls\UrlParserFixture;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getCompleteUri()
 */
class getCompleteUri extends \BaseUnitTest
{
	public function testLocalPath () {
		$oUrl = new UrlParserFixture(__FILE__);
		$this->assertEquals(__FILE__, $oUrl->getCompleteUri());
	}


	public function testNoSchemeIP() {
		$oUrl = new UrlParserFixture('//8.8.8.8');
		$this->assertEquals('http://8.8.8.8/', $oUrl->getCompleteUri());
	}

	public function testUrlNoSchemePath () {
		$oUrl = new UrlParserFixture('//localhost');
		$this->assertEquals('http://localhost/', $oUrl->getCompleteUri());
	}
}
