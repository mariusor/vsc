<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getCompleteParentUri()
 */
class getCompleteParentUri extends \PHPUnit_Framework_TestCase
{
	public function testLocalPath () {
		$oUrl = new UrlParserA_underTest(__FILE__);
		$this->assertEquals('file://' . dirname(__FILE__) . '/', $oUrl->getCompleteParentUri(true));
	}


	public function testNoSchemeIP() {
		$oUrl = new UrlParserA_underTest('//8.8.8.8');
		$this->assertEquals($oUrl->getCompleteUri(true), $oUrl->getCompleteParentUri(true));
	}

	public function testUrlNoSchemePath () {
		$oUrl = new UrlParserA_underTest('//localhost');
		$this->assertEquals($oUrl->getCompleteUri(true), $oUrl->getCompleteParentUri(true));
	}
}
