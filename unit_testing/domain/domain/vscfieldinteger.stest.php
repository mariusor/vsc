<?php
/**
 * @package domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 */
import ('domain/domain/fields');

class vscFieldIntegerTest extends Snap_UnitTestCase {
	private $state;

	public function setUp () {
		$this->state = new vscFieldInteger ('integerField');
	}

	public function tearDown () { 
		unset ($this->state);
	}

	public function testInstantiation () {
		return $this->assertIsA ($this->state, 'vscFieldInteger');
	}

	public function testInstantiationName () {
		return $this->assertEqual (
			$this->state->getName(), 
			'integerField' 
		);
	}
}
