<?php
 /**
 * @author Marius Orcsik <marius@habarnam.ro>
 * @created 2015-02-24
 */
namespace lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\application\sitemaps\ModuleMap;

/**
 * Class getValidPathTest
 * @package lib\application\sitemaps\MappingA
 * @covers \vsc\application\sitemaps\MappingA::getValidPath()
 */
class getValidPathTest extends \PHPUnit_Framework_TestCase {
	public function testSetTemplatePathRelativeNoModuleMap ()
	{
		$oMap = new MappingA_underTest_getValidPath (\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		try {
			$oMap->getValidPath( 'templates' . DIRECTORY_SEPARATOR );
		} catch (\Exception $e) {
			// no module map for the relative path to work
			$this->assertInstanceOf(\Exception::class, $e);
			$this->assertInstanceOf(\vsc\Exception::class, $e);
			$this->assertInstanceOf(\vsc\application\sitemaps\ExceptionSitemap::class, $e);
		}
	}

	public function testSetTemplatePathAbsolute ()
	{
		$oMap = new MappingA_underTest_getValidPath (\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates'.DIRECTORY_SEPARATOR, $oMap->getValidPath( VSC_FIXTURE_PATH . 'templates'.DIRECTORY_SEPARATOR));
	}

	public function testSetTemplatePathRelativeToWithModule ()
	{
		$oModuleMap = new ModuleMap(VSC_FIXTURE_PATH . 'config/map.php', '\A.*\Z');

		$oMap = new MappingA_underTest_getValidPath(\fixtures\application\controllers\GenericFrontController::class, '\A.*\Z');
		$oMap->setModuleMap($oModuleMap);

		$this->assertEquals(VSC_FIXTURE_PATH . 'templates'.DIRECTORY_SEPARATOR, $oMap->getValidPath('templates'.DIRECTORY_SEPARATOR));
		$this->assertEquals(VSC_FIXTURE_PATH . 'templates'.DIRECTORY_SEPARATOR, $oMap->getValidPath('templates'));
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