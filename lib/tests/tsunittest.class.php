<?php
/**
 * @package ts_unit_testing
 * @author Marius Orcsik <marius@habarnam.ro>
 * @date 09.03.03
 */
class tsUnitTest extends TestSuite {
	/**
	 * @var tsUnitTest
	 */
	static private $instance;

	public function __construct () {
		// TODO
	}

	/**
	 * @var integer $argc
	 * @var mixed[] $argv
	 * @return void
	 */
	static public function execute ($argc, $argv = null) {
		$loader = new SimpleFileLoader();
		$result = true;

		$tests = array();
		for ($i = 0; $i < $argc; $i++) {
			if (stristr ($argv[$i], 'package') !== false && isset($argv[$i+1])) {
				$sPackageName = $argv[$i+1];
				break;
			} else {
				$sPackageName = null;
			}
		}

		try {
			$aPackages = self::getInstance()->getTests ($sPackageName);
		} catch (ErrorException $e) {
			// probably we tried to get tests for an invalid package
			echo $e->getMessage() . (isCli () ? "\n" : '<br/>');
			die (0);
		}

		foreach ($aPackages as $sPath) {
			$tests[] = $loader->load ($sPath);
		}

		foreach ($tests as $suite) {
			$result = ($suite->run (new DefaultReporter())) && $result;
		}
		return $result;
	}
	/**
	 * @return tsUnitTest
	 */
	static private function getInstance () {
		if (!(self::$instance instanceof tsUnitTest)) {
			self::$instance = new tsUnitTest ();
		}
		return self::$instance;
	}

	private function getTests ($sPackageName = '') {
		$aFiles = getDirFiles (VSC_TEST_PATH . $sPackageName);
		foreach ($aFiles as $key=>$sPath) {
			if (!stristr($sPath, 'Test.php')) {
				unset($aFiles[$key]);
			}
		}
		return $aFiles;
	}
}