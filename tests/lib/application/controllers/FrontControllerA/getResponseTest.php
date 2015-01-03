<?php
namespace tests\lib\application\controllers\FrontControllerA;
use fixtures\application\processors\ProcessorFixture;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\application\controllers\FrontControllerA;
use vsc\application\sitemaps\ControllerMap;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\HttpResponseA;
use fixtures\presentation\views\NullView;

/**
 * @covers \vsc\application\controllers\FrontControllerA::getResponse()
 */
class getResponse extends \PHPUnit_Framework_TestCase
{
	public function testGetPlainResponse()
	{
		$Controller = new FrontControllerA_underTest_getResponse();
		$Map = new ControllerMap('.', FrontControllerA_underTest_getResponse::class);
		$Controller->setMap($Map);
		$Response = $Controller->getResponse(vsc::getEnv()->getHttpRequest());

		$this->assertInstanceOf(HttpResponseA::class, $Response);
	}

	public function testGetResponseWithProcessor () {
		$r = new PopulatedRequest();
		$p = new ProcessorFixture();

		$Controller = new FrontControllerA_underTest_getResponse();
		$Map = new ControllerMap('.', FrontControllerA_underTest_getResponse::class);
		$Controller->setMap($Map);

		$this->assertInstanceOf(\vsc\presentation\responses\HttpResponseA::class, $Controller->getResponse($r, $p));
	}
}

class FrontControllerA_underTest_getResponse extends FrontControllerA {
	public function getDefaultView () {
		return new NullView();
	}
}
