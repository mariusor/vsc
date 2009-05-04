<?php
/**
 * @package ts_tests
 * @subpackage models
 * @author Marius Orcsik <marius@habarnam.ro>
 */
include_once ('dummytable.class.php');

class fooEntityTest extends UnitTestCase {
	private $state;

	public function setUp() {
		// begin transaction shit - if the case
		$this->state = new dummyTable();
	}

	public function tearDown () {
		unset ($this->state);
	}

	public function testInstantiation (){
		$this->assertIsA($this->state, 'dummyTable');
		$this->assertIsA($this->state, 'fooEntityA');
	}

	public function testFields () {
		foreach ($this->state->getMembers() as $oColumn) {
			$this->assertIsA($oColumn, 'fooFieldA', 'Column ' . var_export($oColumn, true) . ' is not a valid fooField');
		}
	}

	public function testPrimaryKey () {
		$this->state->setPrimaryKey($this->state->payload);
		$this->assertIsA($this->state->getPrimaryKey(), 'fooKeyPrimary');
	}

	public function testGetter () {
		$value = $this->state->getPayload ();
		$this->assertEqual ($value, 2);

		$value = $this->state->getId();
		$this->assertNull($value);
	}

	public function testSetter () {
		$this->state->setPayload (1);
		$value = $this->state->getPayload();

		$this->assertEqual ($value, 1);


		$this->state->setPayload (null);
		$value = $this->state->getPayload();

		$this->assertNull ($value);
	}

	public function testLoadFromArray () {
		$values = array (
			'id' 		=> 1,
			'payload'	=> 'Ana are mere !! test" asd" ',
			'timestamp'	=> date('Y-m-d G:i:s'),
		);

		$this->state->loadFromArray ($values);

		$this->assertEqual($values['id'], 			$this->state->getId());
		$this->assertEqual($values['payload'], 		$this->state->getPayload());
		$this->assertEqual($values['timestamp'], 	$this->state->getTimestamp());
	}
}