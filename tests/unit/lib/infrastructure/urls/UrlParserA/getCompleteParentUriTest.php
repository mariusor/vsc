<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use mocks\infrastructure\urls\UrlParserFixture;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getCompleteParentUri()
 */
class getCompleteParentUri extends \BaseUnitTest
{
	public function testLocalPath () {
		$oUrl = new UrlParserFixture(__FILE__);
		$this->assertEquals('file://' . dirname(__FILE__), $oUrl->getCompleteParentUri(true));
	}


	public function testNoSchemeIP() {
		$oUrl = new UrlParserFixture('//8.8.8.8');
		$this->assertEquals($oUrl->getCompleteUri(true), $oUrl->getCompleteParentUri(true));
	}

	public function testUrlNoSchemePath () {
		$oUrl = new UrlParserFixture('//localhost');
		$this->assertEquals($oUrl->getCompleteUri(true), $oUrl->getCompleteParentUri(true));
	}
}
