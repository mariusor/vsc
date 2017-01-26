<?php
namespace tests\infrastructure\urls\Url;


use mocks\infrastructure\urls\UrlParserFixture;

class getPortTest extends \BaseUnitTest {
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
		$sUrl = UrlParserFixture::makeUrl($aUrlComponents);
		$oUrl = UrlParserFixture::url($sUrl);

		$this->assertEquals($sPort, $oUrl->getPort());
	}
}
