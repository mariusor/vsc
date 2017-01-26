<?php
namespace tests\application\controllers\RESTController;
use mocks\presentation\requests\PopulatedRESTRequest;
use vsc\application\controllers\JsonController;
use vsc\infrastructure\vsc;
use vsc\presentation\views\JsonView;
use vsc\presentation\views\ViewA;
use vsc\rest\application\controllers\RESTController;

/**
 * @covers \vsc\rest\application\controllers\RESTController::getDefaultView()
 */
class getDefaultView extends \BaseUnitTest
{
	public function testBasicGetDefaultView()
	{
		$s = new JsonController();
		$this->assertInstanceOf(JsonView::class, $s->getDefaultView());
		$this->assertInstanceOf(ViewA::class, $s->getDefaultView());
	}

	/**
	 * @fixme
	 */
	public function testGetDefaultViewWithAcceptHeader() {
		$o = new RESTController();

		$oRequest = new PopulatedRESTRequest();
		$oRequest->setHttpAccept('application/json');
		vsc::getEnv()->setHttpRequest($oRequest);

		$oDefaultView = $o->getView();
		$this->assertInstanceOf(JsonView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);

		$oRequest->setHttpAccept('application/xml');
		$oDefaultView = $o->getView();
//		$this->assertInstanceOf(XmlView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);

		$oRequest->setHttpAccept('application/pdf');
		$oDefaultView = $o->getDefaultView();
//		$this->assertInstanceOf(StaticFileView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);
//
		$oRequest->setHttpAccept('image/*');
		$oDefaultView = $o->getDefaultView();
//		$this->assertInstanceOf(StaticFileView::class, $oDefaultView);
		$this->assertInstanceOf(ViewA::class, $oDefaultView);
	}

}
