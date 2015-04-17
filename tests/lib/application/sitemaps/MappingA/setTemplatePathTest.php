<?php
namespace tests\lib\application\sitemaps\MappingA;
use fixtures\application\controllers\GenericFrontController;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\MappingA::setTemplatePath()
 */
class setTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testSetTemplatePathRelativeNoModuleMapUsingDefault ()
	{
		$oMap = new MappingA_underTest_setTemplatePath (GenericFrontController::class, '\A.*\Z');

		$oMap->setTemplatePath ( 'templates/' );
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $oMap->getTemplatePath());

		$oMap->setTemplatePath ( 'templates' );
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $oMap->getTemplatePath());
	}

	public function testSetTemplatePathAbsolute ()
	{
		$oMap = new MappingA_underTest_setTemplatePath (GenericFrontController::class, '\A.*\Z');

		$oMap->setTemplatePath ( VSC_FIXTURE_PATH . 'templates/' );
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testSetTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_setTemplatePath(GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath ( 'templates/' );
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}
}

class MappingA_underTest_setTemplatePath extends MappingA {
}
