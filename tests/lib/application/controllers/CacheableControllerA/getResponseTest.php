<?php
namespace tests\lib\application\controllers\CacheableControllerA;
use vsc\application\sitemaps\ControllerMap;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\HttpResponseA;
use vsc\application\controllers\CacheableControllerA;
use fixtures\presentation\views\NullView;

/**
 * @covers the public method CacheableControllerA::getResponse()
 */
class getResponse extends \PHPUnit_Framework_TestCase
{
	public function testGetPlainResponse()
	{
		$Controller = new CacheableController_underTest_getResponse();
		$Map = new ControllerMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setMap($Map);
		$Response = $Controller->getResponse(vsc::getEnv()->getHttpRequest());

		$this->assertInstanceOf(HttpResponseA::class, $Response);
	}
}

class CacheableController_underTest_getResponse extends CacheableControllerA {

	/**
	 * @returns ViewA
	 */
	public function getDefaultView () {
		return new NullView();
	}
}
