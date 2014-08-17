<?php
/**
 * @package presentation
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.18
 */
namespace vsc\application\processors;

//import ('presentation/processors');

use vsc\domain\models\EmptyModel;
use vsc\presentation\requests\HttpRequestA;

define ('SNAPTEST_ROOT', realpath('/home/habarnam/abs/snaptest/') . DIRECTORY_SEPARATOR);
// snaptest web interface

// STEP 1: Define the absolute path to where snaptest.php is
// Include the ending slash
define('SNAP_WI_PATH', SNAPTEST_ROOT );

// STEP 2: Define the absolute path to your top level test directory
// Include the ending slash
define('SNAP_WI_TEST_PATH', VSC_TEST_PATH);

// STEP 3: Define the URL of this file. This way, we can find it
// once more without weird script url hackery
define('SNAP_WI_URL_PATH', '/vsc/test/');

// STEP 4: Obfuscation. If this is defined to TRUE then full path obfuscation
// will be on and the path informaton will be ommitted from the display side
// of everything. It is strongly encouraged to leave this on unless you are in
// a secure environment and don't mind your entire path being exposed.
define('SNAP_WI_CRYPT', false);

// STEP 5: set the matching path
// Files matching this pattern will be testable
define('SNAP_WI_TEST_MATCH', '^.*\.stest\.php$');

// STEP 6: Relax, you're done. Bask in your awesomeness.
// Go to http://www.example.com/path/to/snaptest_web.dist.php

// --------------------------------------------------------------------------

// include the snaptest web core, which will handle the request, components
// etc. All the heavy lifting should happen well out of sight.

class TestProcessor extends ProcessorA {
	public function init () {
		$sPath = get_include_path();
		set_include_path(
			SNAPTEST_ROOT . PATH_SEPARATOR .
			SNAPTEST_ROOT . DIRECTORY_SEPARATOR . 'core/util' . PATH_SEPARATOR .
			$sPath
		);
		include ('constants.php');
	}

	public function handleRequest (HttpRequestA $oHttpRequest) {
//		require_once (SNAP_WI_PATH . 'snaptest_webcore.php');
		$oModel = new EmptyModel();
		$oModel->setPageTitle ('Unit testing');
		$oModel->setPageContent('Test Controller'. '<hr/><pre>' . var_export ($this->getLocalVars(), true) . '</pre>');

		return $oModel;
	}
}
