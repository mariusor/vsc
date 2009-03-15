<?php
/* Db constants
 -----------------------*/
define ('DB_TYPE', 				'mysqli');
define ('DB_HOST', 				'localhost');
define ('DB_USER', 				'b');
define ('DB_PASS', 				'ASD');
//define ('DB_NAME', 				'b');


usingPackage ('models');
usingPackage ('models/sqldrivers');
//usingPackage ('coreexceptions');
/**
 * mock object for testing the abstract fooTdoA
 */
class fooTdo extends fooTdoA {
//	public function __construct () {
////		throw new tsExceptionUnimplemented(__METHOD__ . ' not implemented.');
//	}
}

class fooAbstractTest extends UnitTestCase {
	public function test_Instantiation () {
		$o = new fooTdo();

		$this->assertIsA($o, 'fooTdoA');
	}

	public function test_getConnection () {
		$o = new fooTdo ();
//		try {
			$o->setConnection (sqlFactory::connect('mysqli'));
//		} catch (tsExceptionModel $e) {
//			// could not connect
//
//		}

		$this->assertIsA($o->getConnection(), 'mySqlIm');
	}
}