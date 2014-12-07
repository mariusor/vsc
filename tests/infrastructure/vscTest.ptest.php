<?php
use vsc\infrastructure\vsc;
use vsc\application\dispatchers\RwDispatcher;

class vscTest extends \PHPUnit_Framework_TestCase {
	private $sFixturesPath;

	public function setUp () {
		$this->sFixturesPath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		vsc::setInstance(new vsc());
	}

	public function tearDown () {
		// @todo
	}

	public function testIsCli () {
		$this->assertTrue(vsc::isCli());
	}

	public function testGetEnv () {
		$this->assertInstanceOf('\\vsc\\infrastructure\\vsc', vsc::getEnv());
	}

	public function testGetDispatcher () {
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');
		$this->assertInstanceOf('\\vsc\\application\\dispatchers\\DispatcherA', $oDispatcher);
	}

	public function testSetDispatcher () {
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = new RwDispatcher();
 		$oDispatcher->loadSiteMap ($this->sFixturesPath . 'map.php');

		vsc::getEnv()->setDispatcher($oDispatcher);
		$this->assertSame($oDispatcher, vsc::getEnv()->getDispatcher());
	}

	public function testGetRequest () {
		$this->assertInstanceOf('\\vsc\\presentation\\requests\\HttpRequestA', vsc::getEnv()->getHttpRequest());
	}

	public function testGetIncludePaths () {
		// =))
		$this->assertEquals(vsc::getIncludePaths(), explode (PATH_SEPARATOR, get_include_path()));
	}
}
