<?php
/**
 * @package domain
 * @subpackage domain
 * @author marius orcsik <marius@habarnam.ro>
 */
include_once ('fixtures/dummytable.class.php');

class vscEntityTest extends Snap_UnitTestCase {
	/**
	 * @var vscDomainObjectA
	 */
	private $state;

	public function setUp() {
		// begin transaction shit - if the case
		$this->state = new dummyTable();
	}

	public function tearDown () {
		unset ($this->state);
	}

	public function testInstantiation1 (){
		return $this->assertIsA($this->state, 'dummyTable');
	}

	public function testInstantiation2 (){
		return $this->assertIsA($this->state, 'vscDomainObjectA');
	}

	public function testFields () {
		foreach ($this->state->getFields() as $oColumn) {
			// this is broken: FIXME
			return $this->assertIsA ( $oColumn, 'vscFieldA');
		}
	}

	public function testPrimaryKey () {
		$this->state->setPrimaryKey($this->state->payload);
		return $this->assertIsA($this->state->getPrimaryKey(), 'vscKeyPrimary');
	}

	public function testGetterInteger () {
		$value = $this->state->getPayload ();
		return $this->assertEqual ($value->getValue(), 2);
	}
	
	public function testGetterNull () {
		$value = $this->state->getId();
		return $this->assertNull($value->getValue());
	}

	public function testSetter () {
		$this->state->setPayload (1);
		$value = $this->state->getPayload();

		return $this->assertEqual ($value->getValue(), 1);


//		$this->state->setPayload (null);
//		$value = $this->state->getPayload();
//
//		$this->assertNull ($value);
	}

	public function testFromArray () {
		$values = array (
			'id' 		=> 1,
			'payload'	=> 'Ana are mere !! test" asd" ',
			'timestamp'	=> date('Y-m-d G:i:s'),
		);

		$this->state->fromArray ($values);

		$aAssertion[] 	= $this->assertEqual($values['id'], 			$this->state->getId()->getValue());
		$aAssertion[]	= $this->assertEqual($values['payload'], 		$this->state->getPayload()->getValue());
		$aAssertion[]	= $this->assertEqual($values['timestamp'], 		$this->state->getTimestamp()->getValue());
		
		// this is dumb
		return $aAssertion[rand(0, 2)];
	}

	public function testToArray () {
		$values = array (
			'id' 		=> 1,
			'payload'	=> 'Ana are mere !! test" asd" ',
			'timestamp'	=> date('Y-m-d G:i:s'),
		);

		$this->state->fromArray ($values);

		$values2 = $this->state->toArray ();

		$aAssertion[] 	= $this->assertEqual($values['id'], 			$values2['id']);
		$aAssertion[] 	= $this->assertEqual($values['payload'], 		$values2['payload']);
		$aAssertion[] 	= $this->assertEqual($values['timestamp'], 		$values2['timestamp']);
		// this is dumb
		return $aAssertion[rand(0, 2)];
	}

	/**
	 * @todo
	 */
	public function testJoinObjects () {
		$a = new dummyTable();

//		$this->state->join ($a, $this->state->getPrimaryKey(), $a->getPrimaryKey());
		$this->todo('Do me: ' . __METHOD__);
		
//		return $this->assertIsA($this->state, 'dummyTable');
	}
}

