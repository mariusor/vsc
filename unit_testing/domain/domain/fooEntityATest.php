<?php
/**
 * @package ts_tests
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 */
import ('models');

class fooEntityATest extends UnitTestCase {

	private function getTestData () {
		return array (
			array ('One', 'Two', 3),
			array (null, 0, 1)
		);
	}

	public function testToArray (){
		$this->assertEqual(2, 2);
	}
}