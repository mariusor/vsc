<?php
/* Db constants
 -----------------------*/
define ('DB_TYPE', 				'mysql');
define ('DB_HOST', 				'localhost');
define ('DB_USER', 				'root');
define ('DB_PASS', 				'ASD');
define ('DB_NAME', 				'b');


usingPackage ('models');
usingPackage ('models/sqldrivers');
usingPackage ('coreexceptions');

class fooTdoAbstractTest extends UnitTestCase {
	public function test_Instantiation () {
		$o = new fooTdo();

		$this->assertIsA($o, 'fooTdoA');
	}

	public function test_getConnection () {
		$o = new fooTdo ();
		try {
			$o->setConnection (sqlFactory::connect('mysqli'));
		} catch (tsExceptionModel $e) {
			// could not connect
		}

		$this->assertIsA($o->getConnection(), 'mySqlIm');
	}

	public function test_createSQL () {
		$o = new dummyTable();
		$oC = new fooTdo();

		echo $oC->outputCreateSQL($o);
	}
}

/**
 * mock object for testing the abstract fooTdoA
 */
class fooTdo extends fooTdoA {
	public function __construct () {
		$this->setConnection(sqlFactory::connect('mysqli'));
	}
}

class dummyTable extends fooEntityA {
	private $id;
	private $payload;

	public function __construct () {
		$this->id 		= new fooColumn ('id', 'int', 11);
		$this->payload 	= new fooColumn ('payload', 'varchar', 255);
	}
}