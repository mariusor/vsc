<?php
/**
 * @package ts_tests
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 */
import ('models');
include ('tdousers.class.php');
class fooUsersTest extends UnitTestCase {

	public function setUp() {
		// begin transaction shit - if the case
	}

//	private function getTestData () {
//		return array (
//			array ('One', 'Two', 3),
//			array (null, 0, 1)
//		);
//	}

	public function testInstantiation (){
		$ousers = new tdoUsers();

		$this->assertIsA($ousers, 'tdoUsers');
	}

	public function testFields () {

	}
}