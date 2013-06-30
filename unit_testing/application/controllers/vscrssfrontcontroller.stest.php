<?php
import ('application');
import ('controllers');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');


class vscRssFrontControllerTest extends Snap_UnitTestCase {
	private $state;
	public function setUp () {
		$this->state = new vscRssController();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new vscRwHttpRequest();
		return $this->assertIsA($this->state->getResponse($oReq),'vscHttpResponseA');
	}
}
