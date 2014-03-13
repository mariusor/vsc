<?php
$BASE_PATH = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
//include ($BASE_PATH . 'vscemptyprocessor.class.php');

import ('application');
import ('processors');
import ('sitemaps');

class vscProcessorEmptyTest extends PHPUnit_Framework_TestCase {
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
		$fixtureValue = array ('test' => null);
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
		$sFixtureMap = realpath(dirname (__FILE__) . '/../dispatchers/fixtures') . '/';
		import ($sFixtureMap);

		$sValue = 'test';

		$oHttpRequest = new vscRwHttpRequest();
		$oNewProcessor = new test();
		$oNewProcessor->return = $sValue;

		$sMapPath = $sFixtureMap .'map.php';
		vsc::getEnv()->getDispatcher()->loadSiteMap($sMapPath);

		$this->assertEquals($sValue, $this->state->delegateRequest($oHttpRequest, $oNewProcessor));
	}
}
