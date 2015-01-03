<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers the public method MappingA::setTemplatePath()
 */
class setTemplatePath extends \PHPUnit_Framework_TestCase
{
	public function testSetTemplatePathRelativeNoModuleMap ()
	{
		$oMap = new MappingA_underTest_setTemplatePath (\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		try {
			$oMap->setTemplatePath ( 'templates/' );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\application\sitemaps\ExceptionSitemap::class, $e);
		}
	}

	public function testSetTemplatePathAbsolute ()
	{
		$oMap = new MappingA_underTest_setTemplatePath (\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$this->assertTrue($oMap->setTemplatePath ( VSC_FIXTURE_PATH . 'templates/' ));
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}

	public function testSetTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_setTemplatePath(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertTrue($oMap->setTemplatePath ( 'templates/' ));
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates/', $oMap->getTemplatePath());
	}
}

class MappingA_underTest_setTemplatePath extends MappingA {
}
