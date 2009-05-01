<?php
/* Db constants
 -----------------------*/
define ('DB_TYPE', 				'mysql');
define ('DB_HOST', 				'localhost');
define ('DB_USER', 				'root');
define ('DB_PASS', 				'ASD');
define ('DB_NAME', 				'b');

include_once ('dummytable.class.php'); // the definition of the entity
usingPackage ('models/foo');
usingPackage ('models/sqldrivers');
usingPackage ('coreexceptions');

class fooTdoAbstractTest extends UnitTestCase {
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
		$o = new dummyTable();
		$oC = new fooTdo();

		$this->assertEqual(1, 1);
		$oC->outputCreateSQL($o);
	}
}

/**
 * mock object for testing the abstract fooTdoA
 */
class fooTdo extends fooTdoA {
	public function __construct () {
		$this->setConnection(sqlFactory::connect('mysql'));
	}
}
