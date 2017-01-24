<?php
 /**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-02-24
 */
namespace lib\application\sitemaps\MappingA;
use mocks\application\controllers\FrontControllerFixture;
use vsc\application\sitemaps\ExceptionSitemap;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;
use vsc\Exception;

/**
 * Class getValidPathTest
 * @package lib\application\sitemaps\MappingA
 * @covers \vsc\application\sitemaps\MappingA::getValidPath()
 */
class getValidPathTest extends \BaseUnitTest {
	public function testSetTemplatePathRelativeNoModuleMap ()
	{
		$oMap = new MappingA_underTest_getValidPath (FrontControllerFixture::class, '\A.*\Z');

		try {
			$oMap->getValidPath( 'templates' . DIRECTORY_SEPARATOR );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
			$this->assertInstanceOf(ExceptionSitemap::class, $e);
		}
	}

	public function testSetTemplatePathAbsolute ()
	{
		$oMap = new MappingA_underTest_getValidPath (FrontControllerFixture::class, '\A.*\Z');

		$this->assertEquals(VSC_MOCK_PATH . 'templates'.DIRECTORY_SEPARATOR, $oMap->getValidPath( VSC_MOCK_PATH . 'templates'.DIRECTORY_SEPARATOR));
	}

	public function testSetTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_MOCK_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_getValidPath(FrontControllerFixture::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertEquals(VSC_MOCK_PATH . 'templates'.DIRECTORY_SEPARATOR, $oMap->getValidPath('templates'.DIRECTORY_SEPARATOR));
		$this->assertEquals(VSC_MOCK_PATH . 'templates'.DIRECTORY_SEPARATOR, $oMap->getValidPath('templates'));
	}
}

class MappingA_underTest_getValidPath extends MappingA {
	/**
	 * @param string $sPath
	 * @return string
	 * @throws ExceptionSitemap
	 */
	public function getValidPath ($sPath) {
		return parent::getValidPath($sPath);
	}
}
