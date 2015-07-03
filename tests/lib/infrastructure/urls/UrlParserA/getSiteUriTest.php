<?php
namespace lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * Class getSiteUriTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::getSiteUri()
 */
class getSiteUriTest extends \PHPUnit_Framework_TestCase {

	public function testBasicGetSiteUri() {
		$test = 'example.com';
		$o = new UrlParserA_underTest_getSiteUri('http://example.com');
		$this->assertEquals($test, $o->getSiteUri());
	}

	public function testGetSiteUriWIthUserPass() {
		$this->markTestSkipped('No username/pass in current implementation');
		$test = 'alladin:test@example.com';
		$o = new UrlParserA_underTest_getSiteUri('http://alladin:test@example.com');
		$this->assertEquals($test, $o->getSiteUri());
	}


}

class UrlParserA_underTest_getSiteUri extends UrlParserA {}
