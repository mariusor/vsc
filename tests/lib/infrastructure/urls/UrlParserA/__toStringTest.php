<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::__toString()
 */
class __toString extends \PHPUnit_Framework_TestCase
{
	public function testEmpty__toString()
	{
		$sUrl = 'http://localhost';
		$o = new UrlParserA_underTest($sUrl);
		$this->assertEquals($sUrl, $o->__toString());
		$this->assertEquals($sUrl, (string)$o);

		$sUrl = 'http://192.168.1.1';
		$o = new UrlParserA_underTest($sUrl);
		$this->assertEquals($sUrl, $o->__toString());
		$this->assertEquals($sUrl, (string)$o);

//		$sUrl = '//localhost';
//		$o = new UrlParserA_underTest($sUrl);
//		$this->assertEquals($sUrl, $o->__toString());
//		$this->assertEquals($sUrl, (string)$o);

//		$sUrl = '//192.168.1.1';
//		$o = new UrlParserA_underTest($sUrl);
//		$this->assertEquals($sUrl, $o->__toString());
//		$this->assertEquals($sUrl, (string)$o);

//		$sUrl = 'localhost';
//		$o = new UrlParserA_underTest($sUrl);
//		$this->assertEquals($sUrl, $o->__toString());
//		$this->assertEquals($sUrl, (string)$o);

//		$sUrl = '192.168.1.1';
//		$o = new UrlParserA_underTest($sUrl);
//		$this->assertEquals($sUrl, $o->__toString());
//		$this->assertEquals($sUrl, (string)$o);
	}
}
