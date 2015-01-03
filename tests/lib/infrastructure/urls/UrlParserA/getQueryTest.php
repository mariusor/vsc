<?php
namespace lib\infrastructure\urls\UrlParserA;


use fixtures\infrastructure\urls\UrlParserA_underTest;

class getQueryTest extends \PHPUnit_Framework_TestCase {
	public function testGetQuery () {
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

		$this->assertEquals($aUrlComponents['query'], $oUrl->getQuery());
	}
}
