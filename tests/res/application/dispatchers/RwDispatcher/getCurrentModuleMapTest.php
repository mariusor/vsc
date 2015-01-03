<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getCurrentModuleMap()
 */
class getCurrentModuleMap extends \PHPUnit_Framework_TestCase
{
	public function testGetCurrentModuleMap ()
	{
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$oProcessor = $o->getProcessController();

		$this->assertInstanceOf( \vsc\application\sitemaps\ModuleMap::class, $o->getCurrentModuleMap());
		$this->assertInstanceOf( \vsc\application\processors\ProcessorA::class, $oProcessor);
	}

}
