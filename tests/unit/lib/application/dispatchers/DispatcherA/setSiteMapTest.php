<?php
namespace tests\lib\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\DispatcherA;
use vsc\application\processors\ProcessorA;
use vsc\ExceptionPath;
use vsc\application\controllers\FrontControllerA;
use vsc\application\sitemaps\RwSiteMap;
use vsc\application\sitemaps\SiteMapA;

/**
 * @covers \vsc\application\dispatchers\DispatcherA::setSiteMap()
 */
class setSiteMap extends \BaseUnitTest
{
	public function testBasicSiteMap()
	{
		$o = new DispatcherA_underTest_setSiteMap();
		$o->setSiteMap(new RwSiteMap());

		$this->assertInstanceOf(SiteMapA::class, $o->getSiteMap());
		$this->assertInstanceOf(RwSiteMap::class, $o->getSiteMap());
	}
}

class DispatcherA_underTest_setSiteMap extends DispatcherA {
	/**
	 * @returns FrontControllerA
	 */
	public function getFrontController()
	{
		// TODO: Implement getFrontController() method.
	}

	/**
	 * @returns ProcessorA
	 */
	public function getProcessController()
	{
		// TODO: Implement getProcessController() method.
	}

	public function getView()
	{
		// TODO: Implement getView() method.
	}

	/**
	 * @param string $sIncPath
	 * @throws ExceptionPath
	 * @return void
	 */
	public function loadSiteMap($sIncPath)
	{
		// TODO: Implement loadSiteMap() method.
	}
}
