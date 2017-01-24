<?php
namespace tests\lib\application\controllers\CacheableControllerA;
use mocks\application\processors\ProcessorFixture;
use mocks\presentation\requests\PopulatedRequest;
use vsc\application\processors\ProcessorA;
use vsc\application\sitemaps\ClassMap;
use vsc\domain\models\CacheableModelA;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\RawHttpRequest;
use vsc\presentation\responses\HttpResponseA;
use vsc\application\controllers\CacheableControllerA;
use mocks\presentation\views\NullView;
use vsc\presentation\responses\HttpResponseType;
use vsc\presentation\views\CacheableViewA;

/**
 * @covers \vsc\application\controllers\CacheableControllerA::getResponse()
 */
class getResponse extends \BaseUnitTest
{
	protected function setUp () {
		vsc::setInstance(new vsc());
	}

	public function testGetPlainResponse()
	{
		$Controller = new CacheableController_underTest_getResponse();
		$Map = new ClassMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setMap($Map);
		$Response = $Controller->getResponse(vsc::getEnv()->getHttpRequest());

		$this->assertInstanceOf(HttpResponseA::class, $Response);
	}

	public function testGetResponseWithProcessor () {
		$r = new PopulatedRequest();
		$p = new ProcessorFixture();

		$Controller = new CacheableController_underTest_getResponse();
		$Map = new ClassMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setMap($Map);

		$this->assertInstanceOf(HttpResponseA::class, $Controller->getResponse($r, $p));
	}

	public function testGetResponseWithCacheableModelThatIsOlder () {
		$now = new \DateTime('now');

		$tomorrow = clone($now);
		$tomorrow->add(new \DateInterval('P1D'));

		$r = $this->getMockBuilder(RawHttpRequest::class)
			->disableOriginalConstructor()
			->getMock();

		$r->method('getIfModifiedSince')
			->willReturn($tomorrow->format('r'));

		vsc::getEnv()->setHttpRequest($r);
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

		$Map = new ClassMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setView($v);
		$Controller->setMap($Map);

		$inTwoWeeks = $now->add(new \DateInterval('P2W'));

		$response = $Controller->getResponse($r, $p);
		$expires = new \DateTime($response->getExpires());
		$this->assertInstanceOf(HttpResponseA::class, $response);
		$this->assertEquals($inTwoWeeks->getTimestamp(),$expires->getTimestamp(), '', 2);
		$this->assertEquals(HttpResponseType::NOT_MODIFIED, $response->getStatus());
	}

	public function testGetResponseWithCacheableModelThatIsNewer () {
		$now = new \DateTime('now');

		$yesterday = clone($now);
		$yesterday->sub(new \DateInterval('P1D'));

		$r = $this->getMockBuilder(RawHttpRequest::class)
			->disableOriginalConstructor()
			->getMock();

		vsc::getEnv()->setHttpRequest($r);

		$r->method('getIfModifiedSince')
			->willReturn($yesterday->format('r'));

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

		$Map = new ClassMap('.', CacheableController_underTest_getResponse::class);
		$Controller->setView($v);
		$Controller->setMap($Map);

		$inTwoWeeks = $now->add(new \DateInterval('P2W'));

		$response = $Controller->getResponse($r, $p);
		$expires = new \DateTime($response->getExpires());
		$this->assertInstanceOf(HttpResponseA::class, $response);
		$this->assertEquals($inTwoWeeks->getTimestamp(),$expires->getTimestamp(), '', 2);
		$this->assertEquals(HttpResponseType::OK, $response->getStatus());
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
