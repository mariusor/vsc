<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use mocks\presentation\requests\PopulatedRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::getTemplatePath()
 */
class getTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testTemplatePath ()
	{
		$sFixturePath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap($sFixturePath . 'map.php');

		$oRequest  = new PopulatedRequest();
		vsc::getEnv()->setHttpRequest($oRequest);

		$genericTemplatePath = VSC_MOCK_PATH.'templates'.DIRECTORY_SEPARATOR;
		$this->assertEquals($genericTemplatePath, $o->getTemplatePath());
	}
}
