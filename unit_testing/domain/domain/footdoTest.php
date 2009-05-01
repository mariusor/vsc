<?php
/* Db constants
 -----------------------*/
define ('DB_TYPE', 				'mysql');
define ('DB_HOST', 				'localhost');
define ('DB_USER', 				'root');
define ('DB_PASS', 				'ASD');
define ('DB_NAME', 				'b');

usingPackage ('models/foo');
usingPackage ('models/sqldrivers');
usingPackage ('coreexceptions');

include_once ('dummytable.class.php'); // the definition of the entity
include_once ('dataobject.class.php'); // the definition of the data object

class fooTdoTest extends UnitTestCase {
	public function test_Instantiation () {
		$o = new fooTdo();

		$this->assertIsA($o, 'fooTdoA');
	}

	public function testGetConnection () {
		$o = new fooTdo ();
		$o->setConnection (sqlFactory::connect('mysql'));
		$this->assertIsA($o->getConnection(), 'mySqlIm');
	}

	public function testCreateSQL () {
		// we should have a separate test for each type of connection
		// the test should be the actual creation
		$o = new dummyTable();
		$oC = new fooTdo();

		$createSQL = $oC->outputCreateSQL($o);

		d (alltrim($createSQL));
	}
}
