<?php
/**
 * @package ts_tests
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 */
usingPackage ('models/foo/fields');

class fooFieldIntegerTest extends UnitTestCase {
	private $state;

	public function setUp () {}

	public function tearDown () { }

	public function testInstantiation () {
		$a = new fooFieldInteger ('integerField');

		$this->assertIsA 	($a, 'fooFieldInteger');
		$this->assertEqual  ($a->getName(), 'integerField', 'The name of the field should be [integerField], but it is [' .$a->getName() . ']');
	}
}
