<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::getMaps()
 */
class getMaps extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new SiteMapA_underTest_getMaps();

		$this->assertEmpty($o->getMaps());
	}
}

class SiteMapA_underTest_getMaps extends SiteMapA {}
