<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class getCurrentUrlTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::getCurrentUrl()
 */
class getCurrentUrlTest extends \BaseUnitTest
{
	public function testBasicGetCurrentUrl()
	{
		$o = new UrlParserA_underTest_getCurrentUrl(UrlParserA_underTest_getCurrentUrl::getRequestUri());
		$this->assertInstanceOf(UrlParserA::class, $o);
		$this->assertInstanceOf(UrlParserA_underTest_getCurrentUrl::class, $o);

		$this->assertEquals(UrlParserA_underTest_getCurrentUrl::getRequestUri(), $o->getCompleteUri());
	}
}

class UrlParserA_underTest_getCurrentUrl extends UrlParserA {
	static protected $queryEncodingType = PHP_QUERY_RFC3986;

	static public function getRequestUri () {
		return 'http://example.com/test/index.html?query=test+123';
	}
}
