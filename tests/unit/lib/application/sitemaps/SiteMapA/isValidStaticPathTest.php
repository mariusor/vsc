<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::isValidStaticPath()
 */
class isValidStaticPath extends \PHPUnit_Framework_TestCase
{
	public function testIsInValidStaticPathWithLocalPHPFile()
	{
		$o = new SiteMapA_underTest_isValidStaticPath();
		$this->assertFalse($o->isValidStaticPath(__FILE__));
	}

	public function testIsValidStaticPathWithLocalJsFile()
	{
		$sPath = VSC_MOCK_PATH . 'static/fixture.css';
		$o = new SiteMapA_underTest_isValidStaticPath();
		$this->assertTrue($o->isValidStaticPath($sPath));
	}
}

class SiteMapA_underTest_isValidStaticPath extends SiteMapA {}
