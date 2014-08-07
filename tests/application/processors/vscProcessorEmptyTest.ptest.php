<?php
// \vsc\import (VSC_FIXTURE_PATH);
use _fixtures\application\processors\testFixtureProcessor;
use vsc\application\sitemaps\vscModuleMap;
use vsc\application\dispatchers\vscRwDispatcher;

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
		return $this->assertInstanceOf('\\vsc\\application\\sitemaps\\vscProcessorMap', $this->state->getMap());
	}

	public function testDelegateRequest () {
		$sValue = 'test';

		$oHttpRequest = new \_fixtures\presentation\requests\vscPopulatedRequest();
		$oNewProcessor = new testFixtureProcessor();
		$oNewProcessor->return = $sValue;

		$sMapPath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR .'map.php';

		\vsc\infrastructure\vsc::getEnv()->setDispatcher(new vscRwDispatcher());
		\vsc\infrastructure\vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $this->state->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
