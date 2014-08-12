<?php
use _fixtures\application\processors\testFixtureProcessor;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\EmptyProcessor;
use vsc\infrastructure\vsc;

class ProcessorEmptyTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var EmptyProcessor
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
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$this->state->setMap($oMap);

		return $this->assertSame ($oMap, $this->state->getMap());
	}
	public function testGetMap () {
		return $this->assertInstanceOf('\\vsc\\application\\sitemaps\\ProcessorMap', $this->state->getMap());
	}

	public function testDelegateRequest () {
		$sValue = 'test';

		$oHttpRequest = new \_fixtures\presentation\requests\PopulatedRequest();
		$oNewProcessor = new testFixtureProcessor();
		$oNewProcessor->return = $sValue;

		$sMapPath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR .'map.php';

		vsc::getEnv()->setDispatcher(new RwDispatcher());
		vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $this->state->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
