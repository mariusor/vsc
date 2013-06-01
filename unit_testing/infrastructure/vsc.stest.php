<?php

class vscTest extends Snap_UnitTestCase {
	private $sFixturesPath;

	public function setUp () {
		$this->sFixturesPath = realpath(dirname(__FILE__) . '/./fixtures') . '/';
	}

	public function tearDown () {
		// @todo
	}

	public function testIsCli () {
		return $this->assertTrue(vsc::isCli());
	}

	public function testIsDevel () {
		return $this->assertTrue (vsc::getEnv()->isDevelopment());
	}

	public function testGetEnv () {
		return $this->assertIsA(vsc::getEnv(), 'vsc');
	}

	public function testGetDispatcher () {
		/* @var $oDispatcher vscRwDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');
		return $this->assertIsA($oDispatcher, 'vscDispatcherA');
	}

	public function testGetRequest () {
		return $this->assertIsA(vsc::getEnv()->getHttpRequest(), 'vscHttpRequestA');
	}

	public function testGetIncludePaths () {
		// =))
		return $this->assertEqual(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}

}