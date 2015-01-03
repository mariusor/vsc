<?php
namespace tests\lib\application\controllers\CacheableControllerA;
use fixtures\application\processors\ProcessorFixture;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\application\sitemaps\ControllerMap;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\HttpResponseA;
use vsc\application\controllers\CacheableControllerA;
use fixtures\presentation\views\NullView;

/**
 * @covers \vsc\application\controllers\CacheableControllerA::getResponse()
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

	public function testGetResponseWithProcessor () {
		$r = new PopulatedRequest();
		$p = new ProcessorFixture();

		$Controller = new CacheableController_underTest_getResponse();
		$Map = new ControllerMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setMap($Map);

		$this->assertInstanceOf(\vsc\presentation\responses\HttpResponseA::class, $Controller->getResponse($r, $p));
	}
}

class CacheableController_underTest_getResponse extends CacheableControllerA {
	public function getDefaultView () {
		return new NullView();
	}
}
