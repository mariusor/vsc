<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 1/4/15
 * Time: 12:47 AM
 */

namespace lib\infrastructure\urls\UrlParserA;


use fixtures\infrastructure\urls\UrlParserA_underTest;

class getTldOfTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers \vsc\infrastructure\urls\UrlParserA::getTldOf
	 */
	public function testGetTldOf () {
		$sHost = 'example.com';

		$sTld = substr($sHost, strrpos ($sHost, '.') + 1);
		$this->assertEquals ($sTld, UrlParserA_underTest::getTldOf($sHost));

		$sHost = 'localhost';
		$this->assertEquals ($sHost, UrlParserA_underTest::getTldOf($sHost));

		$sIp = '192.168.1.1';
		$this->assertFalse(UrlParserA_underTest::getTldOf($sIp));

		$sEmpty = '';
		$this->assertFalse(UrlParserA_underTest::getTldOf($sEmpty));

		$sNull = null;
		$this->assertFalse(UrlParserA_underTest::getTldOf($sNull));
	}
}
