<?php
class vscTest extends PHPUnit_Framework_TestCase {
	private $sFixturesPath;

	public function setUp () {
		$this->sFixturesPath = VSC_FIXTURE_PATH . 'application' . DIRECTORY_SEPARATOR . 'dispatchers' . DIRECTORY_SEPARATOR;
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
		$this->markTestSkipped('Need proper CLI Dispatcher');
		/* @var $oDispatcher vscRwDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');
		return $this->assertInstanceOf('vscDispatcherA', $oDispatcher);
	}

	public function testSetDispatcher () {
		/* @var $oDispatcher vscRwDispatcher */
		$oDispatcher = new vscRwDispatcher();
 		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');

		vsc::getEnv()->setDispatcher($oDispatcher);
		return $this->assertSame($oDispatcher, vsc::getEnv()->getDispatcher());
	}

	public function testGetRequest () {
		return $this->assertInstanceOf('vscRequestA', vsc::getEnv()->getHttpRequest());
	}

	public function testGetIncludePaths () {
		// =))
		return $this->assertEquals(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}

}
