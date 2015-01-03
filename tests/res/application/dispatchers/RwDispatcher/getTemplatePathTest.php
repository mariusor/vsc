<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getTemplatePath()
 */
class getTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testTemplatePath ()
	{
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$this->assertNull($o->getTemplatePath());
	}
}
