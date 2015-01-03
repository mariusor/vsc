<?php
namespace lib\infrastructure\urls\UrlParserA;


use fixtures\infrastructure\urls\UrlParserA_underTest;

class getPortTest extends \PHPUnit_Framework_TestCase {
	public function testGetPort () {
		$sPort = 8080;
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost:' . $sPort,
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$oUrl = new UrlParserA_underTest($sUrl);

		$this->assertEquals($sPort, $oUrl->getPort());
	}
}
