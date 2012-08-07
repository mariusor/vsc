<?php
import ('res/application/controllers');
import ('presentation/responses');
import ('presentation/requests');
import ('presentation/sitemaps');

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
