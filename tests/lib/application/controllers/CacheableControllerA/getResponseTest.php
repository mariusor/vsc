<?php
namespace tests\lib\application\controllers\CacheableControllerA;
use fixtures\application\processors\ProcessorFixture;
use fixtures\presentation\requests\PopulatedRequest;
use vsc\application\processors\ProcessorA;
use vsc\application\sitemaps\ControllerMap;
use vsc\domain\models\CacheableModelA;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\HttpResponseA;
use vsc\application\controllers\CacheableControllerA;
use fixtures\presentation\views\NullView;
use vsc\presentation\views\CacheableViewA;
use vsc\presentation\views\ViewA;

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

	public function testGetResponseWithCacheableModel () {
		$r = new PopulatedRequest();
		$now = new \DateTime('now');

		/** @var ProcessorA $p */
		$p = $this->getMockBuilder(ProcessorA::class)
			->disableOriginalConstructor()
			->getMock();

		$m = $this->getMockBuilder(CacheableModelA::class)
			->setMethods(['getLastModified'])
			->disableOriginalConstructor()
			->getMock();

		$m->method('getLastModified')
			->willReturn($now->format('r'));

		$v = $this->getMockBuilder(CacheableViewA::class)
			->setMethods(['getModel', 'getLastModified', 'getMTime', 'display', 'append', 'assign'])
			->disableOriginalConstructor()
			->getMock();

		$v->expects($this->any())
			->method('getModel')
			->willReturn($m);

		$Controller = new CacheableController_underTest_getResponse();
		$Map = new ControllerMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setView($v);
		$Controller->setMap($Map);

		$inTwoWeeks = $now->add(new \DateInterval('P2W'));

		$response = $Controller->getResponse($r, $p);
		$this->assertInstanceOf(\vsc\presentation\responses\HttpResponseA::class, $response);
		$this->assertEquals($inTwoWeeks->format('r'), $response->getExpires());
	}
}

class CacheableController_underTest_getResponse extends CacheableControllerA {
	private $oView;

	public function setView ($view) {
		$this->oView = $view;
	}

	public function getView () {
		if (!is_null($this->oView)) {
			return $this->oView;
		} else {
			return $this->getDefaultView();
		}
	}

	public function getDefaultView () {
		return new NullView();
	}
}
