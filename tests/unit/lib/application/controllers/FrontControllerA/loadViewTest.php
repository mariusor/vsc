<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 7/4/15
 * Time: 9:33 PM
 */

namespace tests\application\controllers\FrontControllerA;


use mocks\presentation\views\NullView;
use vsc\application\controllers\FrontControllerA;
use vsc\application\processors\EmptyProcessor;
use vsc\application\sitemaps\ClassMap;
use vsc\infrastructure\vsc;
use vsc\presentation\views\ViewA;

class loadViewTest extends \PHPUnit_Framework_TestCase
{
	public function testDefaultPlainView()
	{
		$Controller = new FrontControllerA_underTest_loadView();
		$Map = new ClassMap('.', FrontControllerA_underTest_loadView::class);
		$Controller->setMap($Map);
		$View = $Controller->loadView(vsc::getEnv()->getHttpRequest());

		$this->assertInstanceOf(ViewA::class, $View);
		$this->assertInstanceOf(NullView::class, $View);
	}

	public function testBasicPlainView()
	{
		$Controller = new FrontControllerA_underTest_loadView();
		$ControllerMap = new ClassMap('.', FrontControllerA_underTest_loadView::class);
		$Controller->setMap($ControllerMap);

		$ProcessorMap = new ClassMap('.', EmptyProcessor::class);
		$Processor = new EmptyProcessor();
		$Processor->setMap($ProcessorMap);

		$View = $Controller->loadView(vsc::getEnv()->getHttpRequest(), $Processor);

		$this->assertInstanceOf(ViewA::class, $View);
		$this->assertInstanceOf(NullView::class, $View);
	}

}

class FrontControllerA_underTest_loadView extends FrontControllerA {
	public function loadView($oRequest, $oProcessor = null) {
		return parent::loadView($oRequest, $oProcessor);
	}
	public function getDefaultView () {
		return new NullView();
	}
}
