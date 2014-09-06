<?php
use vsc\application\dispatchers\RwDispatcher;
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

		$this->assertInstanceOf ( \vsc\application\sitemaps\SiteMapA::class, $this->state->getSiteMap () );
	}

	public function testGetRequest () {
		$oRequest = $this->state->getRequest ();

		$oBlaReq = vsc::getEnv ()->getHttpRequest ();

		$this->assertSame ( $oRequest, $oBlaReq );
	}

	public function testGetFrontController () {
		$this->assertTrue ( is_file ( $this->fixturePath . 'map.php' ) );
		$this->assertTrue ( $this->state->loadSiteMap ( $this->fixturePath . 'map.php' ) );

		$oRequest = new PopulatedRequest();
		vsc::getEnv ()->setHttpRequest ( $oRequest );

		try {
			$oFront = $this->state->getFrontController ();

			$this->assertInstanceOf ( \vsc\application\controllers\FrontControllerA::class, $oFront );
		}
		catch ( \Exception $e ) {
			$this->assertInstanceOf ( \vsc\presentation\responses\ExceptionResponseError::class, $e );
		}


	}

	public function testGetProcessController404 () {
		$this->state->loadSiteMap ( $this->fixturePath . 'map.php' );

		$oRequest = new PopulatedRequest();
		$oRequest->setUri ( uniqid ( 'TESTREQ:' ) );
		vsc::getEnv ()->setHttpRequest ( $oRequest );

		$oProcess = $this->state->getProcessController ();

		$this->assertInstanceOf ( \vsc\application\processors\NotFoundProcessor::class, $oProcess );
	}

	public function testGetMapsMap () {
		$this->state->loadSiteMap ( $this->fixturePath . 'map.php' );

		$this->assertInstanceOf ( \vsc\application\sitemaps\SiteMapA::class, $this->state->getSiteMap () );
	}

	public function testGetProcessorController () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$this->assertInstanceOf( \fixtures\application\processors\ProcessorFixture::class, $this->state->getProcessController());
	}

	public function testTemplatePath () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$this->assertNull($this->state->getTemplatePath());
	}

	public function testGetCurrentModuleMap () {
		$this->state->loadSiteMap($this->fixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$oProcessor = $this->state->getProcessController();

		$this->assertInstanceOf( \vsc\application\sitemaps\ModuleMap::class, $this->state->getCurrentModuleMap());
		$this->assertInstanceOf( \vsc\application\processors\ProcessorA::class, $oProcessor);
	}
}
