<?php
namespace tests\lib\application\processors\ProcessorA;
use mocks\application\processors\ProcessorFixture;
use mocks\presentation\requests\PopulatedRequest;
use vsc\application\dispatchers\RwDispatcher;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\processors\ProcessorA::delegateRequest()
 */
class delegateRequest extends \BaseUnitTest
{
	public function testBasicDelegateRequest ()
	{
		$o = new ProcessorFixture();
		$sValue = 'test';

		$oHttpRequest = new PopulatedRequest();
		$oNewProcessor = new ProcessorFixture();
		$oNewProcessor->return = $sValue;

		$sMapPath = VSC_MOCK_PATH . 'config' . DIRECTORY_SEPARATOR .'map.php';

		vsc::getEnv()->setDispatcher(new RwDispatcher());
		vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $o->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
