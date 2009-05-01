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
	private $state;

	public function setUp () {
		$this->state = new fooTdo();
	}
	public function tearDown() {}

	public function test_Instantiation () {
		$this->assertIsA($this->state, 'fooTdo');
		$this->assertIsA($this->state, 'fooTdoA');
	}

	public function testGetConnection () {
		$this->state->setConnection (sqlFactory::connect('mysql'));
		$this->assertIsA($this->state->getConnection(), 'mySqlIm');
	}

	public function testCreateSQL () {
		// we should have a separate test for each type of connection
		// the test should be the actual creation
		$o = new dummyTable();

		$createSQL = $this->state->outputCreateSQL($o);
		$this->state->getConnection()->selectDatabase('test');
		$i = $this->state->getConnection()->query($createSQL);

//		$this->assertTrue($i, '');
	}
}
