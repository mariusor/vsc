<?php
namespace tests\lib\infrastructure\urls\UrlParserA;
use mocks\infrastructure\urls\UrlParserFixture;
use vsc\infrastructure\urls\Url;
use vsc\infrastructure\urls\UrlParserA;

/**
 * @covers \vsc\infrastructure\urls\UrlParserA::parse_url()
 */
class parse_url extends \BaseUnitTest
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

		$oUrl = new Url();
		$oUrl->setScheme($aUrlComponents['scheme']);
		$oUrl->setHost($aUrlComponents['host']);
		$oUrl->setPath($aUrlComponents['path']);
		$oUrl->setQuery($aUrlComponents['query']);
		$oUrl->setFragment($aUrlComponents['fragment']);
		$sUrl = UrlParserFixture::makeUrl($aUrlComponents);

		$this->assertInstanceOf(Url::class, UrlParserFixture::parse_url($sUrl));
		$this->assertEquals($oUrl, UrlParserFixture::parse_url($sUrl));
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

		$oUrl = new Url();
		$oUrl->setScheme($aUrlComponents['scheme']);
		$oUrl->setHost($aUrlComponents['host']);
		$oUrl->setPath($aUrlComponents['path']);
		$oUrl->setQuery($aUrlComponents['query']);
		$oUrl->setFragment($aUrlComponents['fragment']);

		$this->assertEquals($oUrl, UrlParserFixture::parse_url(__FILE__));
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

		$oUrl = new Url();
		$oUrl->setScheme($aUrlComponents['scheme']);
		$oUrl->setHost($aUrlComponents['host']);
		$oUrl->setPath($aUrlComponents['path']);
		$oUrl->setQuery($aUrlComponents['query']);
		$oUrl->setFragment($aUrlComponents['fragment']);

		$sUrl = UrlParserFixture::makeUrl($aUrlComponents);
		$this->assertEquals($oUrl, UrlParserFixture::parse_url($sUrl));
	}

	/**
	 * @test
	 */
	public function parse_urlWithNullUrl () {
		$oUrl = new Url();
		$this->assertEquals($oUrl, UrlParserFixture::parse_url(null));
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
		$sUrl = UrlParserFixture::makeUrl($aUrlComponents);

		$oUrl = new Url();
		$oUrl->setScheme($aUrlComponents['scheme']);
		$oUrl->setHost($aUrlComponents['host']);
		$oUrl->setPath($aUrlComponents['path']);
		$oUrl->setQuery($aUrlComponents['query']);
		$oUrl->setFragment($aUrlComponents['fragment']);
		$this->assertEquals($oUrl, UrlParserFixture::parse_url('/etc/passwd'));
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

		$oUrl = new Url();
		$oUrl->setScheme($aUrlComponents['scheme']);
		$oUrl->setHost($aUrlComponents['host']);
		$oUrl->setPath($aUrlComponents['path']);
		$oUrl->setQuery($aUrlComponents['query']);
		$oUrl->setFragment($aUrlComponents['fragment']);
		$this->assertEquals($oUrl, UrlParserFixture::parse_url('//example.com/'));
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

		$oUrl = new Url();
		$oUrl->setScheme($aUrlComponents['scheme']);
		$oUrl->setHost($aUrlComponents['host']);
		$oUrl->setPath($aUrlComponents['path']);
		$oUrl->setQuery($aUrlComponents['query']);
		$oUrl->setFragment($aUrlComponents['fragment']);
		$this->assertEquals($oUrl, UrlParserFixture::parse_url('//127.0.0.1/'));
	}
}
