<?php
import ('urls');

class vscUrlRWParserTest extends Snap_UnitTestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
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

}