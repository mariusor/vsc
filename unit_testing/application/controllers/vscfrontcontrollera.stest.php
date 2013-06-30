<?php
import ('application');
import ('controllers');
import ('sitemaps');
import ('presentation');
import ('responses');
import ('requests');


class vscFrontControllerATest extends Snap_UnitTestCase  {
private $state;
	public function setUp () {
		$this->state = new vscGenericFrontController();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new vscRwHttpRequest();
		return $this->assertIsA($this->state->getResponse($oReq),'vscHttpResponseA');
	}
}
