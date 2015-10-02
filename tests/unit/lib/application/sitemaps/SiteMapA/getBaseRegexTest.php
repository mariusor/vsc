<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::getBaseRegex()
 */
class getBaseRegex extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization ()
	{
		$o = new SiteMapA_underTest_getBaseRegex();
		$this->assertEmpty($o->getBaseRegex());
	}
}

class SiteMapA_underTest_getBaseRegex extends SiteMapA {}
