<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures');

import ('application');
import ('sitemaps');
class vscProcessorEmptyTest extends Snap_UnitTestCase {
	private $state;
	public function setUp () {
		$this->state = new vscEmptyProcessor();
	}

	public function tearDown () {
		$this->state = null;
	}

	public function testGetSetVar () {
		$randVal = rand();
		if ($this->state->setVar('test', $randVal)) {
			return $this->assertEqual($randVal, $this->state->getVar('test'));
		} else {
			return $this->assertTrue(false, 'Couldn\'t set var [test]');
		}
	}
	public function testGetLocalVars () {
		$fixtureValue = array ('test' => null);
		return $this->assertEqual($fixtureValue, $this->state->getLocalVars());
	}

	public function testSetLocalVars () {
		$fixtureValue = array ('test' => null);
		$localValue = array('test2' => 'grrr');
		$this->state->setLocalVars($localValue, true);
		return $this->assertEqual(array_merge($fixtureValue, $localValue), $this->state->getLocalVars());
	}

	public function testGetSetMap () {
		$oMap = new vscModuleMap(__FILE__, '\A.*\Z');
		$this->state->setMap($oMap);

		return $this->assertIdentical($oMap, $this->state->getMap());
	}
	public function testGetMap () {
		return $this->assertIsA($this->state->getMap(), 'vscProcessorMap');
	}

	public function testDelegateRequest () {
		return $this->todo('Processor delegation needs more complicated set up');
// 		d ($this->state->delegateRequest($oHttpRequest, $oNewProcessor))
	}
}