<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class getSiteUriTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::getSiteUri()
 */
class getSiteUriTest extends \BaseUnitTest {

	public function testBasicGetSiteUri() {
		$test = 'example.com';
		$this->assertEquals($test, UrlParserA_underTest_getSiteUri::getSiteUri());
	}

}

class UrlParserA_underTest_getSiteUri extends UrlParserA {
	static public function getRequestUri() {
		return 'http://example.com';
	}
}
