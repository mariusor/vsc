<?php
namespace tests\res\application\sitemaps\ClassMap;
use vsc\application\sitemaps\ClassMap;

/**
 * @covers \vsc\application\sitemaps\ClassMap::isValidMap()
 */
class isValidObjectPath extends \PHPUnit_Framework_TestCase
{
	public function testIsInValidObjectPathWithStaticFile()
	{
		$sPath = VSC_MOCK_PATH . 'static/fixture.css';
		$this->assertFalse(ClassMap::isValidMap($sPath));
	}

	public function testIsValidObjectPathWithPHPFile()
	{
		$sPath = isValidObjectPath::class;
		$this->assertTrue(ClassMap::isValidMap($sPath));
	}
}
