<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getProcessController()
 */
class getProcessController extends \PHPUnit_Framework_TestCase
{
	public function tearDown() {
		vsc::setInstance(new vsc());
	}

	public function testGetProcessController404 ()
	{
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap ( $sFixturePath . 'map.php' );

		$oRequest = new PopulatedRequest();
		$oRequest->setUri(uniqid());
		vsc::getEnv()->setHttpRequest ( $oRequest );

		$oProcess = $o->getProcessController ();

		$this->assertInstanceOf ( \vsc\application\processors\NotFoundProcessor::class, $oProcess );
	}

	public function testGetProcessorController ()
	{
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$this->assertInstanceOf( \fixtures\application\processors\ProcessorFixture::class, $o->getProcessController());
	}
}
