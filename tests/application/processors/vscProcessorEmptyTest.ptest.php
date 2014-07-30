<?php
// \vsc\import (VSC_FIXTURE_PATH);

class vscProcessorEmptyTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var vscEmptyProcessor
	 */
	private $state;
	public function setUp () {
		$this->state = new testFixtureProcessor();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetSetVar () {
		$randVal = rand();
		if ($this->state->setVar('test', $randVal)) {
			return $this->assertEquals($randVal, $this->state->getVar('test'));
		} else {
			return $this->assertTrue(false, 'Couldn\'t set var [test]');
		}
	}

	public function testGetLocalVars () {
		$fixtureValue = array ('test' => null);
		return $this->assertEquals($fixtureValue, $this->state->getLocalVars());
	}

	public function testSetLocalVars () {
		$fixtureValue = $this->state->getLocalVars();
		$localValue = array('test2' => 'grrr');

		$this->state->setLocalVars($localValue, true);
		return $this->assertEquals(array_merge($fixtureValue, $localValue), $this->state->getLocalVars());
	}

	public function testGetSetMap () {
		$oMap = new vscModuleMap(__FILE__, '\A.*\Z');
		$this->state->setMap($oMap);

		return $this->assertSame ($oMap, $this->state->getMap());
	}
	public function testGetMap () {
		return $this->assertInstanceOf('vscProcessorMap', $this->state->getMap());
	}

	public function testDelegateRequest () {
		$sValue = 'test';

		$oHttpRequest = new vscRwHttpRequest();
		$oNewProcessor = new testFixtureProcessor();
		$oNewProcessor->return = $sValue;

		$sMapPath = VSC_FIXTURE_PATH . 'application' . DIRECTORY_SEPARATOR . 'dispatchers' . DIRECTORY_SEPARATOR .'map.php';

		vsc::getEnv()->setDispatcher(new vscRwDispatcher());
		vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $this->state->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
