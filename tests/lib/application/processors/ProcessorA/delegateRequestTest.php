<?php
namespace tests\lib\application\processors\ProcessorA;
use fixtures\application\processors\ProcessorFixture;
use vsc\application\dispatchers\RwDispatcher;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\processors\ProcessorA::delegateRequest()
 */
class delegateRequest extends \PHPUnit_Framework_TestCase
{
	public function testBasicDelegateRequest ()
	{
		$o = new ProcessorFixture();
		$sValue = 'test';

		$oHttpRequest = new \fixtures\presentation\requests\PopulatedRequest();
		$oNewProcessor = new ProcessorFixture();
		$oNewProcessor->return = $sValue;

		$sMapPath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR .'map.php';

		vsc::getEnv()->setDispatcher(new RwDispatcher());
		vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $o->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
