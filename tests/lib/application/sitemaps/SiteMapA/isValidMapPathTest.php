<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::isValidMapPath()
 */
class isValidMapPath extends \PHPUnit_Framework_TestCase
{
	public function testIsInValidMapPathWithStaticFile()
	{
		$sPath = VSC_FIXTURE_PATH . 'static/fixture.css';
		$o = new SiteMapA_underTest_isValidMapPath();
		$this->assertFalse($o->isValidMapPath($sPath));
	}

	public function testIsInValidMapPathWithPHPFile()
	{
		$sPath = __FILE__;
		$o = new SiteMapA_underTest_isValidMapPath();
		$this->assertFalse($o->isValidMapPath($sPath));
	}

	public function testIsValidMapPathWithPHPFile()
	{
		$sPath = VSC_FIXTURE_PATH . 'config/map.php';
		$o = new SiteMapA_underTest_isValidMapPath();
		$this->assertTrue($o->isValidMapPath($sPath));
	}
}

class SiteMapA_underTest_isValidMapPath extends SiteMapA {}
