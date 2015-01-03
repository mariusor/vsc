<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use fixtures\infrastructure\urls\UrlParserA_underTest;
use vsc\infrastructure\urls\UrlParserA;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::parse_url()
 */
class parse_url extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function parse_urlFullHttpUrl () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost',
			'user'		=> 'habarnam',
			'pass'		=> 'dsa',
			'path'		=> '/ana/are/mere',
			'query'		=> array (
				'test' => '1',
				'cucu' => 'mucu'
			),
			'fragment'	=> 'test321'
		);

		$aQuery = array();
		foreach ($aUrlComponents['query'] as $key => $val) {
			$aQuery[] = $key . '=' . $val;
		}
		$sQuery = implode('&', $aQuery);

		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA::parse_url($sUrl));
	}
	/**
	 * @test
	 */
	public function parse_urlFullLocalPath () {
		$aUrlComponents = array (
			'scheme'	=> 'file',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$this->assertEquals($aUrlComponents, UrlParserA::parse_url(__FILE__));
	}
	/**
	 * @test
	 */
	public function parse_urlFullLocalhostPath () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA::parse_url($sUrl));
	}
}
