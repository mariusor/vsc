<?php
namespace tests\lib\application\sitemaps\SiteMapA;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\sitemaps\SiteMapA::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testUseLess()
	{
		$o = new SiteMapA_underTest___construct();
		$this->assertInstanceOf(SiteMapA::class, $o);
	}
}

class SiteMapA_underTest___construct extends SiteMapA {}
