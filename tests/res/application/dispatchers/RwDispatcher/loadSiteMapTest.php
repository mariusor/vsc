<?php
namespace tests\res\application\dispatchers\RwDispatcher;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\ErrorProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\ExceptionError;

/**
 * @covers the public method RwDispatcher::loadSiteMap()
 */
class loadSiteMap extends \PHPUnit_Framework_TestCase
{
	public function testLoadSiteMap ()
	{
		$Exception = new ExceptionError('test', 123);
		$o = new ErrorProcessor($Exception);

		$oMap = new ClassMap(ErrorProcessor::class, '.*');
		$o->setMap($oMap);
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();
		$o->loadSiteMap ( $sFixturePath . 'map.php' );

		$this->assertInstanceOf ( \vsc\application\sitemaps\SiteMapA::class, $o->getSiteMap () );
	}
}
