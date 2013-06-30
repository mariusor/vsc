<?php
import ('application');
import ('controllers');
import ('processors');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');

define ('BASE_PATH', dirname (__FILE__) . '/fixtures/');
import (BASE_PATH);

class vscRssFrontControllerTest extends Snap_UnitTestCase {
	private $state;

	public function setUp () {
		$this->state = new vscRssController();

		$oMap = new vscControllerMap(__FILE__, '\A\Z');
		$this->state->setMap($oMap);
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new vscRwHttpRequest();

		return $this->assertIsA($this->state->getResponse($oReq),'vscHttpResponseA');
	}
}
