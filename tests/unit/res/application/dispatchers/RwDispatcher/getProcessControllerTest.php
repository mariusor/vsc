<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use mocks\application\processors\ProcessorFixture;
use vsc\application\dispatchers\RwDispatcher;
use mocks\presentation\requests\PopulatedRequest;
use vsc\application\processors\ErrorProcessor;
use vsc\application\processors\NotFoundProcessor;
use vsc\application\processors\StaticFileProcessor;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getProcessController()
 */
class getProcessController extends \BaseUnitTest
{
	public function tearDown() {
		vsc::setInstance(new vsc());
	}

	public function testGetProcessController404 ()
	{
		$sFixturePath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap ( $sFixturePath . 'map.php' );

		$oRequest = new PopulatedRequest();
		$oRequest->setUri(uniqid());
		vsc::getEnv()->setHttpRequest ( $oRequest );

		$oProcess = $o->getProcessController ();

		$this->assertInstanceOf ( ErrorProcessor::class, $oProcess );
	}

	public function testGetProcessorController ()
	{
		$sFixturePath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$this->assertInstanceOf( ProcessorFixture::class, $o->getProcessController());
	}

	public function testGetStaticFile ()
	{
		$sFixturePath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest = new PopulatedRequest();
		$oRequest->setUri('/fixture.css');
		vsc::getEnv()->setHttpRequest($oRequest);

		$this->assertInstanceOf( StaticFileProcessor::class, $o->getProcessController());
	}
}
