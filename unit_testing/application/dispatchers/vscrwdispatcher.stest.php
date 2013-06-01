<?php
define ('BASE_PATH', dirname (__FILE__) . '/fixtures/');

import ('application/dispatchers');
import (BASE_PATH);
$sCurPath = realpath(dirname (__FILE__) . '/../../presentation/requests/fixtures/vscpopulatedrequest.class.php');
include ($sCurPath);

class vscRwDispatcherTest  extends Snap_UnitTestCase {
	/**
	 * @var vscRwDispatcher
	 */
	private $state;
	private $fixturePath;

	public function setUp () {
		$this->fixturePath = BASE_PATH;
		$this->state = vsc::getEnv()->getDispatcher();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testLoadSiteMap () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');
		return $this->assertIsA ($this->state->getSiteMap(), 'vscSiteMapA');
	}

	public function testGetRequest () {
		$oReq = $this->state->getRequest();

		$oBlaReq = vsc::getEnv()->getHttpRequest();

		return $this->assertIdentical ($oReq, $oBlaReq);
	}

	public function testGetFrontController () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		$oFront = $this->state->getFrontController();

		return $this->assertIsA($oFront, 'vscFrontControllerA');
	}

	public function testGetProcessController404 () {
		$this->state->loadSiteMap ($this->fixturePath . '/map.php');
		$oProcess = $this->state->getProcessController();

		return $this->assertIsA($oProcess, 'vsc404Processor');
	}

	public function testGetMapsMap () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		return $this->assertIsA ($this->state->getSiteMap(), 'vscSiteMapA');
	}

	public function testGetProcessorController () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oReq  = new vscPopulatedRequest();
		vsc::getEnv()->setHttpRequest($oReq);

		return $this->assertIsA($this->state->getProcessController(), 'test');
	}

	public function testTemplatePath () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oReq  = new vscPopulatedRequest();
		vsc::getEnv()->setHttpRequest($oReq);

		return $this->assertNull($this->state->getTemplatePath());
	}

	public function testGetCurrentModuleMap () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');


		$oReq  = new vscPopulatedRequest();
		vsc::getEnv()->setHttpRequest($oReq);

		$oProcessor = $this->state->getProcessController();

		return $this->assertIsA($this->state->getCurrentModuleMap(), 'vscModuleMap');
	}
}
