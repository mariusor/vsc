<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getCompleteUri()
 */
class getCompleteUri extends \PHPUnit_Framework_TestCase
{
	public function testLocalPath () {
		$oUrl = new UrlParserA_underTest(__FILE__);
		$this->assertEquals(__FILE__, $oUrl->getCompleteUri());
	}


	public function testNoSchemeIP() {
		$oUrl = new UrlParserA_underTest('//8.8.8.8');
		$this->assertEquals('http://8.8.8.8', $oUrl->getCompleteUri(true));
	}

	public function testUrlNoSchemePath () {
		$oUrl = new UrlParserA_underTest('//localhost');
		$this->assertEquals('http://localhost', $oUrl->getCompleteUri(true));
	}
}
