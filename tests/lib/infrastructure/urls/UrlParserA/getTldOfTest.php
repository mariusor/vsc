<?php
namespace lib\infrastructure\urls\UrlParserA;


use fixtures\infrastructure\urls\UrlParserFixture;

class getTldOfTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers \vsc\infrastructure\urls\UrlParserA::getTldOf
	 */
	public function testGetTldOf () {
		$sHost = 'example.com';

		$sTld = substr($sHost, strrpos ($sHost, '.') + 1);
		$this->assertEquals ($sTld, UrlParserFixture::getTldOf($sHost));

		$sHost = 'localhost';
		$this->assertEquals ($sHost, UrlParserFixture::getTldOf($sHost));

		$sIp = '192.168.1.1';
		$this->assertFalse(UrlParserFixture::getTldOf($sIp));

		$sEmpty = '';
		$this->assertFalse(UrlParserFixture::getTldOf($sEmpty));

		$sNull = null;
		$this->assertFalse(UrlParserFixture::getTldOf($sNull));
	}
}
