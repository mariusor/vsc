<?php
use vsc\application\dispatchers\vscRwDispatcher;

class vscRwDispatcherTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var vscRwDispatcher
	 */
	private $state;
	private $fixturePath;

	public function setUp () {
		$this->fixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$this->state = new vscRwDispatcher();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testLoadSiteMap () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');
		return $this->assertInstanceOf('vsc\\application\\sitemaps\\vscSiteMapA', $this->state->getSiteMap());
	}

	public function testGetRequest () {
		$oRequest = $this->state->getRequest();

		$oBlaReq = \vsc\infrastructure\vsc::getEnv()->getHttpRequest();

		return $this->assertSame($oRequest, $oBlaReq);
	}

	public function testGetFrontController () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		$oRequest = new \_fixtures\presentation\requests\vscPopulatedRequest();
		\vsc\infrastructure\vsc::getEnv()->setHttpRequest($oRequest);

		$oFront = $this->state->getFrontController();

		return $this->assertInstanceOf('vsc\\application\\controllers\\vscFrontControllerA', $oFront);
	}

	public function testGetProcessController404 () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		$oRequest = new \_fixtures\presentation\requests\vscPopulatedRequest();
		$oRequest->setReturnUri(uniqid('TESTREQ:'));
		\vsc\infrastructure\vsc::getEnv()->setHttpRequest($oRequest);

		$oProcess = $this->state->getProcessController();

		return $this->assertInstanceOf('vsc\\application\\processors\\vsc404Processor', $oProcess);
	}

	public function testGetMapsMap () {
		$this->state->loadSiteMap ($this->fixturePath . 'map.php');

		return $this->assertInstanceOf ('vsc\\application\\sitemaps\\vscSiteMapA', $this->state->getSiteMap());
	}

	public function testGetProcessorController () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new \_fixtures\presentation\requests\vscPopulatedRequest();
		\vsc\infrastructure\vsc::getEnv()->setHttpRequest($oRequest);

		return $this->assertInstanceOf('_fixtures\\application\\processors\\testFixtureProcessor', $this->state->getProcessController());
	}

	public function testTemplatePath () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new \_fixtures\presentation\requests\vscPopulatedRequest();
		\vsc\infrastructure\vsc::getEnv()->setHttpRequest($oRequest);

		return $this->assertNull($this->state->getTemplatePath());
	}

	public function testGetCurrentModuleMap () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new \_fixtures\presentation\requests\vscPopulatedRequest();
		\vsc\infrastructure\vsc::getEnv()->setHttpRequest($oRequest);

		$oProcessor = $this->state->getProcessController();

		return $this->assertInstanceOf('vsc\\application\\sitemaps\\vscModuleMap', $this->state->getCurrentModuleMap());
	}
}
