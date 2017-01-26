<?php
namespace tests\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testUseLess()
	{
		$o = new SiteMapA_underTest___construct();
		$this->assertInstanceOf(SiteMapA::class, $o);
	}
}

class SiteMapA_underTest___construct extends SiteMapA {}
