<?php
use vsc\infrastructure\vsc;
use vsc\application\dispatchers\RwDispatcher;

class vscTest extends \PHPUnit_Framework_TestCase {
	private $sFixturesPath;

	public function setUp () {
		$this->sFixturesPath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
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
		return $this->assertInstanceOf('\\vsc\\infrastructure\\vsc', vsc::getEnv());
	}

	public function testGetDispatcher () {
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');
		return $this->assertInstanceOf('\\vsc\\application\\dispatchers\\DispatcherA', $oDispatcher);
	}

	public function testSetDispatcher () {
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = new RwDispatcher();
 		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');

		vsc::getEnv()->setDispatcher($oDispatcher);
		return $this->assertSame($oDispatcher, vsc::getEnv()->getDispatcher());
	}

	public function testGetRequest () {
		return $this->assertInstanceOf('\\vsc\\presentation\\requests\\RequestA', vsc::getEnv()->getHttpRequest());
	}

	public function testGetIncludePaths () {
		// =))
		return $this->assertEquals(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}

}
