<?php
namespace lib\infrastructure\urls\UrlParserA;


use fixtures\infrastructure\urls\UrlParserA_underTest;

class getQueryStringTest extends \PHPUnit_Framework_TestCase {
	public function testGetQueryString () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost',
			'user'		=> 'test',
			'pass'		=> '123',
			'path'		=> '',
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$oUrl = new UrlParserA_underTest($sUrl);

		$this->assertEquals(UrlParserA_underTest::makeQuery($aUrlComponents['query']), $oUrl->getQueryString());
	}
}
