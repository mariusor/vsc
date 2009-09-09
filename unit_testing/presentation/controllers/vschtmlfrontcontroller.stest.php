<?php
class vscHtmlFrontControllerTest extends Snap_UnitTestCase  {
private $state;
	public function setUp () {
		import ('presentation/controllers');
		$this->state = new vscHtmlFrontController();
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