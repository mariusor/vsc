<?php
class vscRwDispatcherTest  extends Snap_UnitTestCase {
	private $state;

	public function setUp () {
		import ('presentation/dispatchers');

		$this->state = new vscRwDispatcher();
	}
	public function tearDown () {
		$this->state = null;
	}

	public function testLoadSiteMap () {
		define ('BASE_PATH', dirname (__FILE__) . '/fixtures/');

		$this->state->loadSiteMap (BASE_PATH);
		return $this->assertIsA ($this->state->getSiteMap(), 'vscSiteMapA');
	}

	public function testGetRequest () {
		$oReq = $this->state->getRequest();

		import ('presentation');
		$oBlaReq = vsc::getHttpRequest();

		return $this->assertIdentical ($oReq, $oBlaReq);
	}

	public function testGetFrontController () {
		$oFront = $this->state->getFrontController();

		return $this->assertIsA($oFront, 'vscFrontControllerA');
	}

	public function testGetProcessControllerNull () {
		$oProcess = $this->state->getProcessController();
		return $this->assertNull($oProcess);
	}

	public function testGetMapsMap () {
		define ('BASE_PATH', dirname (__FILE__) . '/fixtures/');

		$this->state->loadSiteMap (BASE_PATH);
		$sCurPath = realpath(dirname (__FILE__) . '/../requests/fixtures/vscpopulatedrequest.class.php');
		include ($sCurPath);
		$oBlaReq = new vscPopulatedRequest ();
		//d ($this->state->getRequest());
		//d ($this->state->getProcessController());
		return $this->assertIsA ($this->state->getSiteMap(), 'vscSiteMapA');
	}
}
