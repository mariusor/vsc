<?php
use fixtures\application\processors\ProcessorFixture;
use vsc\application\sitemaps\ModuleMap;
use vsc\application\dispatchers\RwDispatcher;
use vsc\application\processors\EmptyProcessor;
use vsc\infrastructure\vsc;

class ProcessorFixtureTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var EmptyProcessor
	 */
	private $state;
	public function setUp () {
		$this->state = new ProcessorFixture();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetSetVar () {
		$randVal = rand();
		if ($this->state->setVar('test', $randVal)) {
			$this->assertEquals($randVal, $this->state->getVar('test'));
		} else {
			$this->assertTrue(false, 'Couldn\'t set var [test]');
		}
	}

	public function testGetLocalVars () {
		$fixtureValue = array ('test' => null);
		$this->assertEquals($fixtureValue, $this->state->getLocalVars());
	}

	public function testSetLocalVars () {
		$fixtureValue = $this->state->getLocalVars();
		$localValue = array('test2' => 'grrr');

		$this->state->setLocalVars($localValue, true);
		$this->assertEquals(array_merge($fixtureValue, $localValue), $this->state->getLocalVars());
	}

	public function testGetSetMap () {
		$oMap = new ModuleMap(__FILE__, '\A.*\Z');
		$this->state->setMap($oMap);

		$this->assertSame ($oMap, $this->state->getMap());
	}
	public function testGetMap () {
		$this->assertInstanceOf(\vsc\application\sitemaps\ProcessorMap::class, $this->state->getMap());
	}

	public function testDelegateRequest () {
		$sValue = 'test';

		$oHttpRequest = new \fixtures\presentation\requests\PopulatedRequest();
		$oNewProcessor = new ProcessorFixture();
		$oNewProcessor->return = $sValue;

		$sMapPath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR .'map.php';

		vsc::getEnv()->setDispatcher(new RwDispatcher());
		vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $this->state->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
