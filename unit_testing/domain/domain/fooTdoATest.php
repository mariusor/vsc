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

	public function testGetConnection () {
		$o = new fooTdo ();
		$o->setConnection (sqlFactory::connect('mysql'));
		$this->assertIsA($o->getConnection(), 'mySqlIm');
	}

	public function testCreateSQL () {
		$o = new dummyTable();
		$oC = new fooTdo();

		$this->assertEqual(1, 1);
		echo $oC->outputCreateSQL($o);
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

class dummyTable extends fooEntityA {
	public $id;
	public $payload;

	public function __construct () {
		$this->setName('dummy');
		$this->id 		= new fooFieldInteger('id');
		$this->payload 	= new fooFieldInteger ('payload');
		
		$this->setPrimaryKey ($this->id);
	}
}