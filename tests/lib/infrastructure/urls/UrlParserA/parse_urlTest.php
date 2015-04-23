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
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url($sUrl));
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
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url(__FILE__));
	}
	/**
	 * @test
	 */
	public function parse_urlWithQUeryContainingEncodedChars () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'example.com',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '/test/index.html',
			'query'		=> [
				'q' => 'test 123'
			],
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url($sUrl));
	}

	/**
	 * @test
	 */
	public function parse_urlWithNullUrl () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '/test/ana:are/test:123/', // from the $_SERVER defined in vsc_phpunittest_environment.php
			'query'		=> [
			],
			'fragment'	=> ''
		);
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url(null));
	}

	/**
	 * @test
	 */
	public function parse_urlWithInaccessibleLocalFile () {
		$aUrlComponents = array (
			'scheme'	=> 'file',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '/etc/passwd',
			'query'		=> [
			],
			'fragment'	=> ''
		);
		$sUrl = UrlParserA_underTest::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url('/etc/passwd'));
	}
	/**
	 * @test
	 */
	public function parse_urlWithoutProtocol () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'example.com',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '/',
			'query'		=> [
			],
			'fragment'	=> ''
		);
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url('//example.com/'));
	}

	/**
	 * @test
	 */
	public function parse_urlIPWithoutProtocol () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> '127.0.0.1',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '/',
			'query'		=> [
			],
			'fragment'	=> ''
		);
		$this->assertEquals($aUrlComponents, UrlParserA_underTest::parse_url('//127.0.0.1/'));
	}
}
