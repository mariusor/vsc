<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getPath
 */
class getPathTest extends \PHPUnit_Framework_TestCase {
	public function testGetPath () {
		$aUrlComponents = array (
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$oUrl = new UrlParserA_underTest($sUrl);

		$this->assertEquals(__FILE__, $oUrl->getPath());
	}

}
