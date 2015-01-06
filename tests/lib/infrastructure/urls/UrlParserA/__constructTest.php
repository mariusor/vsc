<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlParserA;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasicInstantiation()
	{
		$o = new UrlParserA_underTest__construct();
		$this->assertEmpty($o->getUrl());
//		$this->assertEmpty($o->getCompleteUri());
//		$this->assertEmpty($o->getPath());
//		$this->assertEmpty($o->getDomain());
//		$this->assertEmpty($o->getFragment());
//		$this->assertEmpty($o->getFullQueryString());
//		$this->assertEmpty($o->getPort());
//		$this->assertEmpty($o->getUser());
//		$this->assertEmpty($o->getScheme());
//		$this->assertEmpty($o->getQuery());
//		$this->assertEmpty($o->getQueryString());
//		$this->assertEquals('', $o->getCompleteParentUri());
//		$this->assertEquals('', $o->getFullFragmentString());
//		$this->assertEquals('', $o->getPass());
	}

	public function testBasicInstantiationWithUrl()
	{
		$sUrl = 'http://localhost';
		$o = new UrlParserA_underTest__construct($sUrl);
		$this->assertEquals($sUrl, $o->getUrl());

		$sUrl = 'http://192.168.1.1';
		$o = new UrlParserA_underTest__construct($sUrl);
		$this->assertEquals($sUrl, $o->getUrl());

		$sUrl = '//localhost';
		$o = new UrlParserA_underTest__construct($sUrl);
		$this->assertEquals($sUrl, $o->getUrl());

		$sUrl = '//192.168.1.1';
		$o = new UrlParserA_underTest__construct($sUrl);
		$this->assertEquals($sUrl, $o->getUrl());

		$sUrl = 'localhost';
		$o = new UrlParserA_underTest__construct($sUrl);
		$this->assertEquals($sUrl, $o->getUrl());

		$sUrl = '192.168.1.1';
		$o = new UrlParserA_underTest__construct($sUrl);
		$this->assertEquals($sUrl, $o->getUrl());
	}
}

class UrlParserA_underTest__construct extends UrlParserA {}
