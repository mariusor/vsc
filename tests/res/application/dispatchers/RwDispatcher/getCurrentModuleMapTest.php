<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use mocks\presentation\requests\PopulatedRequest;
use vsc\application\processors\ProcessorA;
use vsc\application\sitemaps\ModuleMap;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentModuleMap()
 */
class getCurrentModuleMap extends \PHPUnit_Framework_TestCase
{
	public function testGetCurrentModuleMap ()
	{
		$sFixturePath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$oProcessor = $o->getProcessController();

		$this->assertInstanceOf( ModuleMap::class, $o->getCurrentModuleMap());
		$this->assertInstanceOf( ProcessorA::class, $oProcessor);
	}

}
