<?php
class vscHtmlFrontControllerTest extends Snap_UnitTestCase  {
private $state;
	public function setUp () {
		import ('application/controllers');
		$this->state = new vscXhtmlFrontController();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetResponse() {
		import ('presentation/responses');
		import ('presentation/requests');

		$oReq = new vscRwHttpRequest();
		return $this->assertIsA($this->state->getResponse($oReq),'vscHttpResponseA');
	}
}
