<?php
use \vsc\infrastructure\urls\UrlRWParser;
use \vsc\infrastructure\urls\UrlParserA;

class UrlRWParserTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	static public function makeQuery ($aQueryComponents) {
		$sQuery = '';
		if (count($aQueryComponents) > 1) {
			$aQuery = array();
			foreach ($aQueryComponents as $key => $val) {
				$aQuery[] = $key . '=' . $val;
			}
			$sQuery = implode('&', $aQuery);
		}
		return $sQuery;
	}

	static public function makeUrl ($aUrlComponents) {
		$sUrl = '';
		if (!empty ($aUrlComponents['scheme'])) {
			$sUrl .= $aUrlComponents['scheme'] . '://';
		}
		if (!empty ($aUrlComponents['host'])) {
			if (!empty ($aUrlComponents['user']) ) {
				$sUrl .= $aUrlComponents['user'];
				if (!empty ($aUrlComponents['pass']) ) {
					$sUrl .= ':' . $aUrlComponents['pass'];
				}
				$sUrl .= '@';
			}
			$sUrl .= $aUrlComponents['host'];
		}
		if (!empty ($aUrlComponents['path'] )) {
			$sUrl .= $aUrlComponents['path'];
		}
		$sQuery = self::makeQuery($aUrlComponents['query']);
		if (!empty ($sQuery)) {
			$sUrl .= '?' . $sQuery;
		}
		if (!empty($aUrlComponents['fragment'])) {

			$sUrl .= '#' . $aUrlComponents['fragment'];
		}
		return $sUrl;
	}

	public function testHasSchemeTrue () {
		$oUrl = new UrlRWParser('file://' . __FILE__);
		$this->assertTrue ($oUrl->hasScheme());
	}

	public function testHasSchemeFalse () {
		//$this->markTestSkipped('Need to implement hasScheme vs. displayScheme');
		$oUrl = new UrlRWParser('//localhost');
		$this->assertFalse ($oUrl->hasScheme());
	}

	public function testParseUrlFullHttpUrl () {
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

		$sUrl = self::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA::parse_url($sUrl));
	}

	public function testParseUrlFullLocalPath () {
		$aUrlComponents = array (
			'scheme'	=> 'file',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA::parse_url(__FILE__));
	}

	public function testParseUrlFullLocalhostPath () {
		$aUrlComponents = array (
				'scheme'	=> 'http',
				'host'		=> 'localhost',
				'user'		=> '',
				'pass'		=> '',
				'path'		=> __FILE__,
				'query'		=> array(),
				'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$this->assertEquals($aUrlComponents, UrlParserA::parse_url($sUrl));
	}

	public function testLocalPath () {
		$oUrl = new UrlRWParser(__FILE__);
		$this->assertTrue($oUrl->getCompleteUri() == __FILE__);
	}

	public function testIsLocal() {
		$oUrl = new UrlRWParser(__FILE__);
		$this->assertTrue($oUrl->isLocal());
	}

	public function testIsRemote() {
		$oUrl = new UrlRWParser('google.com');
		$this->assertFalse($oUrl->isLocal());
	}

	public function testIsRemoteIP() {
		$oUrl = new UrlRWParser('8.8.8.8');
		$this->assertFalse($oUrl->isLocal());
	}

	public function testNoSchemeIP() {
		$oUrl = new UrlRWParser('//8.8.8.8');
		$this->assertTrue($oUrl->getCompleteUri(true) == 'http://8.8.8.8');
	}

	public function testUrlNoSchemePath () {
		$oUrl = new UrlRWParser('//localhost');
		$this->assertTrue($oUrl->getCompleteUri(true) == 'http://localhost');
	}

	public function testAddPath () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/are/mere';

		$oUrl = new UrlRWParser($sLocalHost);
		$oUrl->addPath($sStr);

		$this->assertEquals($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sStr . '/');
	}

	public function testAddRelativePathWithParentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/../are/mere';

		$oUrl = new UrlRWParser($sLocalHost);
		$oUrl->addPath($sStr);

		$sParentStr = substr($sStr, strpos($sStr, '../') + strlen ('../'));
		$this->assertEquals($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sParentStr . '/');
	}

	public function testAddRelativePathWithCurrentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/./are/mere';

		$oUrl = new UrlRWParser($sLocalHost);
		$oUrl->addPath($sStr);

		$sCurrentStr = str_replace('./', '', $sStr);
		$this->assertEquals($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sCurrentStr . '/');
	}

	public function testGetParentPath () {
		$aUrlComponents = array (
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$oUrl = new UrlRWParser($sUrl);

		$this->assertEquals(dirname(__FILE__) . '/', $oUrl->getParentPath(1));
	}

	public function testGetPath () {
		$aUrlComponents = array (
			'scheme'	=> '',
			'host'		=> '',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> __FILE__,
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$oUrl = new UrlRWParser($sUrl);

		$this->assertEquals(__FILE__, $oUrl->getPath());
	}

	public function testGetPass () {
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost',
			'user'		=> 'test',
			'pass'		=> '123',
			'path'		=> '',
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$oUrl = new UrlRWParser($sUrl);

		$this->assertEquals($aUrlComponents['pass'], $oUrl->getPass());
	}

	public function testGetPort () {
		$sPort = 8080;
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost:' . $sPort,
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> array(),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$oUrl = new UrlRWParser($sUrl);

		$this->assertEquals($sPort, $oUrl->getPort());
	}

	public function testGetQuery () {
		$sPort = '8080';
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> array(
				'test' => 123,
				'ana' => 'mere'
			),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$oUrl = new UrlRWParser($sUrl);

		$this->assertEquals($aUrlComponents['query'], $oUrl->getQuery());
	}

	public function testGetQueryPath () {
		$sPort = '8080';
		$aUrlComponents = array (
			'scheme'	=> 'http',
			'host'		=> 'localhost',
			'user'		=> '',
			'pass'		=> '',
			'path'		=> '',
			'query'		=> array(
				'test' => 123,
				'ana' => 'mere'
			),
			'fragment'	=> ''
		);
		$sUrl = self::makeUrl($aUrlComponents);
		$oUrl = new UrlRWParser($sUrl);

		$this->assertEquals(self::makeQuery($aUrlComponents['query']), $oUrl->getQueryString());
	}

	/**
	 * @covers \vsc\infrastructure\urls\UrlParserA::getTldOf
	 */
	public function testGetTldOf () {
		$sHost = 'example.com';

		$sTld = substr($sHost, strrpos ($sHost, '.') + 1);
		$this->assertEquals ($sTld, UrlRWParser::getTldOf($sHost));

		$sHost = 'localhost';
		$this->assertEquals ($sHost, UrlRWParser::getTldOf($sHost));

		$sIp = '192.168.1.1';
		$this->assertFalse(UrlRWParser::getTldOf($sIp));

		$sEmpty = '';
		$this->assertFalse(UrlRWParser::getTldOf($sEmpty));

		$sNull = null;
		$this->assertFalse(UrlRWParser::getTldOf($sNull));
	}
}
