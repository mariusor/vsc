#!/usr/bin/php
<?php

include ('config.inc.php');
include ('../vsc.inc.php');

if (PHP_MAJOR_VERSION < 5) {
	echo 'LibVSC only works for versions of PHP >= 5. Your current version is: ' . phpversion() . nl();
	exit (0);
}
import ('coreexceptions');
set_include_path (get_include_path() . PATH_SEPARATOR . UNITTEST_PATH);
// the simpletest is full of warnings and strict problems
try {
	include_once ('unit_tester.php');
	include_once ('mock_objects.php');
	include_once ('collector.php');
	include_once ('default_reporter.php');
} catch (tsExceptionError $e) {
	// simpletest is full of bugs - so it generates warnings
	echo $e->getMessage() . ' [' . $e->getSeverityString() . ']' . nl ();
	echo $e->getFile() . ' - ' .$e->getLine () .nl ();
}

ini_set ('display_errors', '1'); error_reporting (E_ALL);
set_error_handler ('exceptions_error_handler');
try {
	import ('tests');
	set_include_path (get_include_path() . PATH_SEPARATOR . VSC_TEST_PATH);
	$result = tsUnitTest::execute ($_SERVER['argc'], $_SERVER['argv']);
} catch (tsExceptionPackageImport $e) {
	// could not import the tests package
	echo $e->getMessage() . nl ();
	echo $e->getFile() . ' - ' .$e->getLine () . nl ();
	echo $e->getTraceAsString();
	echo nl();
	exit (1);
} catch (tsExceptionAutoload $e) {
	// could not load the tsUnitTest class
	echo $e->getMessage() . nl();
	exit (1);
}

if (SimpleReporter::inCli()) {
	exit ($result ? 0 : 1);
}