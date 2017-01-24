<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use mocks\infrastructure\urls\UrlParserFixture;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::getPath
 */
class getPathTest extends \BaseUnitTest {
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
		$sUrl = UrlParserFixture::makeUrl($aUrlComponents);
		$oUrl = new UrlParserFixture($sUrl);

		$this->assertEquals(__FILE__, $oUrl->getPath());
	}

}
