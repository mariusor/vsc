<?php
namespace tests\lib\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\ControllerMapT;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ControllerMapT::getMainTemplatePath()
 */
class getMainTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testGetMainTemplatePath ()
	{
		$oMap = new ControllerMapT_underTest_getMainTemplatePath(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$oMap->setMainTemplatePath(VSC_FIXTURE_PATH . 'templates/');
		$oMap->setTemplate('main.tpl.php');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}

	public function testGetMainTemplatePathRelative ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new ControllerMapT_underTest_getMainTemplatePath(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setMainTemplatePath ( 'templates/' );

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getMainTemplatePath());
	}
}

class ControllerMapT_underTest_getMainTemplatePath extends MappingA {
	use ControllerMapT;
}
