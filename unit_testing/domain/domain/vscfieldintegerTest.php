<?php
/**
 * @package domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 */
import ('domain/domain/fields');

class vscFieldIntegerTest extends UnitTestCase {
	private $state;

	public function setUp () {}

	public function tearDown () { }

	public function testInstantiation () {
		$a = new vscFieldInteger ('integerField');

		$this->assertIsA 	($a, 'vscFieldInteger');
		$this->assertEqual  ($a->getName(), 'integerField', 'The name of the field should be [integerField], but it is [' .$a->getName() . ']');
	}
}
