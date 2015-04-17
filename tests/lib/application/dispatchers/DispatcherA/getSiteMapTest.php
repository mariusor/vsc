<?php
namespace tests\lib\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\dispatchers\DispatcherA::getSiteMap()
 */
class getSiteMap extends \PHPUnit_Framework_TestCase
{
	public function testGetMapsMap ()
	{
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$o->loadSiteMap ( $sFixturePath . 'map.php' );

		$this->assertInstanceOf ( SiteMapA::class, $o->getSiteMap () );
	}

}
