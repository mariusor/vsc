<?php
namespace tests\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\application\sitemaps\SiteMapA;
use vsc\ExceptionError;

/**
 * @covers \vsc\application\dispatchers\RwDispatcher::loadSiteMap()
 */
class loadSiteMap extends \BaseUnitTest
{
	public function testLoadSiteMap ()
	{
		$Exception = new ExceptionError('test', 123);
		$o = new ErrorProcessor($Exception);

		$oMap = new ClassMap(ErrorProcessor::class, '.*');
		$o->setMap($oMap);
		$sFixturePath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();
		$o->loadSiteMap ( $sFixturePath . 'map.php' );

		$this->assertInstanceOf ( SiteMapA::class, $o->getSiteMap () );
	}
}
