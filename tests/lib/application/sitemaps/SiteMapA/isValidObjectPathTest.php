<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::isValidObjectPath()
 */
class isValidObjectPath extends \PHPUnit_Framework_TestCase
{
	public function testIsInValidObjectPathWithStaticFile()
	{
		$sPath = VSC_FIXTURE_PATH . 'static/fixture.css';
		$o = new SiteMapA_underTest_isValidObjectPath();
		$this->assertFalse($o->isValidObjectPath($sPath));
	}

	public function testIsValidObjectPathWithPHPFile()
	{
		$sPath = __FILE__;
		$o = new SiteMapA_underTest_isValidObjectPath();
		$this->assertTrue($o->isValidObjectPath($sPath));
	}
}

class SiteMapA_underTest_isValidObjectPath extends SiteMapA {}
