<?php
vsc\import (VSC_FIXTURE_PATH);

vsc\import ('application/dispatchers');

//$sCurPath = realpath(dirname (__FILE__) . '/../../presentation/requests/_fixtures/vscpopulatedrequest.class.php');
//require ($sCurPath);

class vscRwDispatcherTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var vscRwDispatcher
	 */
	private $state;
	private $fixturePath;

	public function setUp () {
		$this->fixturePath = VSC_FIXTURE_PATH . 'application' . DIRECTORY_SEPARATOR . 'dispatchers' . DIRECTORY_SEPARATOR;
		$this->state = new vscRwDispatcher();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testLoadSiteMap () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');
		return $this->assertInstanceOf('vscSiteMapA', $this->state->getSiteMap());
	}

	public function testGetRequest () {
		$oReq = $this->state->getRequest();

		$oBlaReq = vsc::getEnv()->getHttpRequest();

		return $this->assertSame($oReq, $oBlaReq);
	}

	public function testGetFrontController () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		$oFront = $this->state->getFrontController();

		return $this->assertInstanceOf('vscFrontControllerA', $oFront);
	}

	public function testGetProcessController404 () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');
		$oProcess = $this->state->getProcessController();

		return $this->assertInstanceOf('vsc404Processor', $oProcess);
	}

	public function testGetMapsMap () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		return $this->assertInstanceOf ('vscSiteMapA', $this->state->getSiteMap());
	}

	public function testGetProcessorController () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oReq  = new vscPopulatedRequest();
		vsc::getEnv()->setHttpRequest($oReq);

		return $this->assertInstanceOf('testFixtureProcessor', $this->state->getProcessController());
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

		return $this->assertInstanceOf('vscModuleMap', $this->state->getCurrentModuleMap());
	}
}
