<?php
/**
 * @package ts_tests
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 */
import ('models');
class tdoEntityATest extends UnitTestCase {

	private function getTestData () {
		return array (
			array ('One', 'Two', 3),
			array (null, 0, 1)
		);
	}

	public function testToArray (){
//		try {
			$o = new tdoEntityA ();
//		} catch (AutoloadException $e) {
//			echo $e->getTraceAsString();
//		} catch (Exception $e) {
//			// TODO proper exception handling
//			echo $e->getTraceAsString();
//		}

		$this->assertIsA ($o, 'tdoEntity', 'Failed initialization of our test object');
	}

	public function test123 () {
		$this->assertEqual(2, 2, 'it works');
	}
}