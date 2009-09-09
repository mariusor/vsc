<?php
class vscRwDispatcherTest  extends Snap_UnitTestCase {
	public function setUp () {
		// @todo
	}
	public function tearDown () {
		// @todo
	}

	public function testLoadSiteMap () {
		return $this->todo ('Loading the sitemap is not yet implementd.');
	}
	public function testGetRequest () {
		return $this->todo ('getRequest() is not yet implemented in the dispatchers');
	}

	public function testGetFrontController () {
		import ('presentation/dispatchers');
		$new = new vscRwDispatcher();
		$oFront = $new->getFrontController();

		return $this->assertIsA($oFront, 'vscFrontControllerA');
	}

	public function testGetProcessControllerNull () {
		import ('presentation/dispatchers');
		$new = new vscRwDispatcher();

		$oProcess = $new->getProcessController();
		return $this->assertNull($oProcess);
	}
}