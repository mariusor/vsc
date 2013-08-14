<?php
class vscTest extends PHPUnit_Framework_TestCase {
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
		return $this->assertInstanceOf('vsc', vsc::getEnv());
	}

	public function testGetDispatcher () {
		/* @var $oDispatcher vscRwDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');
		return $this->assertInstanceOf('vscDispatcherA', $oDispatcher);
	}

	public function testGetRequest () {
		return $this->assertInstanceOf('vscHttpRequestA', vsc::getEnv()->getHttpRequest());
	}

	public function testGetIncludePaths () {
		// =))
		return $this->assertEquals(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}

}