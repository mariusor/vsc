<?php
namespace tests\res\application\sitemaps\ModuleMap;
use vsc\application\sitemaps\ModuleMap;

/**
 * @covers \vsc\application\sitemaps\ModuleMap::isValidMap()
 */
class isValidMap extends \PHPUnit_Framework_TestCase
{
	public function testIsInValidMapPathWithStaticFile()
	{
		$sPath = VSC_MOCK_PATH . 'static/fixture.css';
		$this->assertFalse(ModuleMap::isValidMap($sPath));
	}

	public function testIsInValidMapPathWithPHPFile()
	{
		$sPath = __FILE__;
		$this->assertFalse(ModuleMap::isValidMap($sPath));
	}

	public function testIsValidMapPathWithPHPFile()
	{
		$sPath = VSC_MOCK_PATH . 'config/map.php';
		$this->assertTrue(ModuleMap::isValidMap($sPath));
	}
}
