<?php
import ('urls');

class vscUrlRWParserTest extends Snap_UnitTestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}
/*/
	static public function makeUrl ($aUrlComponents) {
		if (count($aUrlComponents['query']) > 1) {
			$aQuery = array();
			foreach ($aUrlComponents['query'] as $key => $val) {
				$aQuery[] = $key . '=' . $val;
			}
			$sQuery = implode('&', $aQuery);
		} else {
			$sQuery = '';
		}

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
		if (!empty ($sQuery)) {
			$sUrl .= '?' . $sQuery;
		}
		if (!empty($aUrlComponents['fragment'])) {

			$sUrl .= '#' . $aUrlComponents['fragment'];
		}
	}
/**/

	public function testHasSchemeTrue () {
		$oUrl = new vscUrlRWParser(__FILE__);
		return $this->assertTrue ($oUrl->hasScheme());
	}

	public function testHasSchemeFalse () {
		$oUrl = new vscUrlRWParser('//localhost');
		return $this->assertFalse ($oUrl->hasScheme());
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
		$sUrl = $aUrlComponents['scheme'] . '://' .
				$aUrlComponents['user'] . ':' . $aUrlComponents['pass'] . '@' .
				$aUrlComponents['host'] . $aUrlComponents['path'] .
				'?' . $sQuery . '#' . $aUrlComponents['fragment'];

		return $this->assertEqual($aUrlComponents, vscUrlParserA::parse_url($sUrl));
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
		$sUrl = $aUrlComponents['scheme'] . '://' . $aUrlComponents['host'] . $aUrlComponents['path'];
		return $this->assertEqual($aUrlComponents, vscUrlParserA::parse_url(__FILE__));
	}

	public function testParseUrlFullLocalPath () {
		$aUrlComponents = array (
				'scheme'	=> 'http',
				'host'		=> 'localhost',
				'user'		=> '',
				'pass'		=> '',
				'path'		=> __FILE__,
				'query'		=> array(),
				'fragment'	=> ''
		);
		$sUrl = $aUrlComponents['scheme'] . '://' . $aUrlComponents['host'] . $aUrlComponents['path'];
		return $this->assertEqual($aUrlComponents, vscUrlParserA::parse_url(__FILE__));
	}

	public function testLocalPath () {
		$oUrl = new vscUrlRWParser(__FILE__);
		return $this->assertTrue($oUrl->getCompleteUri() == __FILE__);
	}

	public function testIsLocal() {
		$oUrl = new vscUrlRWParser(__FILE__);
		return $this->assertTrue($oUrl->isLocal());
	}

	public function testIsRemote() {
		$oUrl = new vscUrlRWParser('goole.com');
		return $this->assertFalse($oUrl->isLocal());
	}

	public function testIsRemoteIP() {
		$oUrl = new vscUrlRWParser('8.8.8.8');
		return $this->assertFalse($oUrl->isLocal());
	}

	public function testNoSchemeIP() {
		$oUrl = new vscUrlRWParser('//8.8.8.8');
		return $this->assertTrue($oUrl->getCompleteUri(true) == 'http://8.8.8.8');
	}

	public function testUrlNoSchemePath () {
		$oUrl = new vscUrlRWParser('//localhost');
		return $this->assertTrue($oUrl->getCompleteUri(true) == 'http://localhost');
	}

	public function testAddPath () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/are/mere';

		$oUrl = new vscUrlRWParser($sLocalHost);
		$oUrl->addPath($sStr);

		return $this->assertEqual($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sStr . '/');
	}

	public function testAddRelativePathWithParentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/../are/mere';

		$oUrl = new vscUrlRWParser($sLocalHost);
		$oUrl->addPath($sStr);

		$sParentStr = substr($sStr, strpos($sStr, '../') + strlen ('../'));
		return $this->assertEqual($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sParentStr . '/');
	}

	public function testAddRelativePathWithCurrentDirectory () {
		$sLocalHost = 'http://localhost';
		$sStr = 'ana/./are/mere';

		$oUrl = new vscUrlRWParser($sLocalHost);
		$oUrl->addPath($sStr);

		$sCurrentStr = str_replace('./', '', $sStr);
		return $this->assertEqual($oUrl->getCompleteUri(true), $sLocalHost . '/' . $sCurrentStr . '/');
	}
}