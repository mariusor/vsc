<?php
use vsc\application\dispatchers\RwDispatcher;
use \vsc\presentation\responses\ExceptionResponseError;
use \fixtures\presentation\requests\PopulatedRequest;
use \vsc\infrastructure\vsc;

class RwDispatcherTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var RwDispatcher
	 */
	private $state;
	private $fixturePath;

	public function setUp () {
		$this->fixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$this->state = new RwDispatcher();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testLoadSiteMap () {
		$this->state->loadSiteMap ( $this->fixturePath . 'map.php' );

		return $this->assertInstanceOf ( '\\vsc\\application\\sitemaps\\SiteMapA', $this->state->getSiteMap () );
	}

	public function testGetRequest () {
		$oRequest = $this->state->getRequest ();

		$oBlaReq = vsc::getEnv ()->getHttpRequest ();

		return $this->assertSame ( $oRequest, $oBlaReq );
	}

	public function testGetFrontController () {
		$this->assertTrue ( is_file ( $this->fixturePath . 'map.php' ) );
		$this->assertTrue ( $this->state->loadSiteMap ( $this->fixturePath . 'map.php' ) );

		$oRequest = new PopulatedRequest();
		vsc::getEnv ()->setHttpRequest ( $oRequest );

		try {
			$oFront = $this->state->getFrontController ();

			return $this->assertInstanceOf ( '\\vsc\\application\\controllers\\FrontControllerA', $oFront );
		}
		catch ( \Exception $e ) {
			return $this->assertInstanceOf ( '\\vsc\\presentation\\responses\\ExceptionResponseError', $e );
		}


	}

	public function testGetProcessController404 () {
		$this->state->loadSiteMap ( $this->fixturePath . 'map.php' );

		$oRequest = new PopulatedRequest();
		$oRequest->setUri ( uniqid ( 'TESTREQ:' ) );
		vsc::getEnv ()->setHttpRequest ( $oRequest );

		$oProcess = $this->state->getProcessController ();

		return $this->assertInstanceOf ( '\\vsc\\application\\processors\\NotFoundProcessor', $oProcess );
	}

	public function testGetMapsMap () {
		$this->state->loadSiteMap ( $this->fixturePath . 'map.php' );

		return $this->assertInstanceOf ( '\\vsc\\application\\sitemaps\\SiteMapA', $this->state->getSiteMap () );
	}

	public function testGetProcessorController () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		return $this->assertInstanceOf('\\fixtures\\application\\processors\\testFixtureProcessor', $this->state->getProcessController());
	}

	public function testTemplatePath () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		return $this->assertNull($this->state->getTemplatePath());
	}

	public function testGetCurrentModuleMap () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$oProcessor = $this->state->getProcessController();

		return $this->assertInstanceOf('\\vsc\\application\\sitemaps\\ModuleMap', $this->state->getCurrentModuleMap());
	}
}
