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

	public function testUrlNoSchemePath () {
		$oUrl = new vscUrlRWParser('//localhost');
		return $this->assertTrue($oUrl->getCompleteUri(true) == 'http://localhost');
	}
}