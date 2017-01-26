<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use mocks\application\sitemaps\MapFixture;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMapTrait;

/**
 * @covers \vsc\application\sitemaps\MappingA::setTemplatePath()
 */
class setTemplatePath extends \BaseUnitTest
{
	public function testSetTemplatePathRelativeNoModuleMapUsingDefault ()
	{
		$oMap = new MappingA_underTest_setTemplatePath (FrontControllerFixture::class, '\A.*\Z');

		$oMap->setTemplatePath ( 'templates/' );
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $oMap->getTemplatePath());

		$oMap->setTemplatePath ( 'templates' );
		$this->assertEquals(VSC_RES_PATH . 'templates' . DIRECTORY_SEPARATOR, $oMap->getTemplatePath());
	}

	public function testSetTemplatePathAbsolute ()
	{
		$oMap = new MappingA_underTest_setTemplatePath (FrontControllerFixture::class, '\A.*\Z');

		$oMap->setTemplatePath ( VSC_MOCK_PATH . 'templates/' );
		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testSetTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_setTemplatePath(FrontControllerFixture::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$oMap->setTemplatePath ( 'templates/' );
		$this->assertEquals(VSC_MOCK_PATH . 'templates/', $oMap->getTemplatePath());
	}
}

class MappingA_underTest_setTemplatePath extends MapFixture {
	use ModuleMapTrait;
}
