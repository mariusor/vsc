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
		$this->assertTrue($oUrl->getCompleteUri() == __FILE__);
	}


	public function testNoSchemeIP() {
		$oUrl = new UrlParserA_underTest('//8.8.8.8');
		$this->assertTrue($oUrl->getCompleteUri(true) == 'http://8.8.8.8');
	}

	public function testUrlNoSchemePath () {
		$oUrl = new UrlParserA_underTest('//localhost');
		$this->assertTrue($oUrl->getCompleteUri(true) == 'http://localhost');
	}
}
