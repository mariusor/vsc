<?php
import ('res/application/controllers');
import ('presentation/responses');
import ('presentation/requests');
import ('presentation/sitemaps');

class vscHtmlFrontControllerTest extends Snap_UnitTestCase  {
private $state;
	public function setUp () {
		$this->state = new vscXhtmlController();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		$oReq = new vscRwHttpRequest();
		return $this->assertIsA($this->state->getResponse($oReq),'vscHttpResponseA');
	}
}
