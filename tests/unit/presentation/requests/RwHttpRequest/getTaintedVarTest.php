<?php
namespace tests\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getTaintedVar()
 */
class getTaintedVar extends \BaseUnitTest
{

	public function testGetTaintedVarCorrect() {
		$o = new PopulatedRequest();
		$this->assertEquals('123', $o->getVar('test'));
	}

	public function testGetTaintedVar() {
		$o = new PopulatedRequest();

		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		foreach ($ExistingTaintedVars as $Key => $Value) {
			$this->assertEquals($Value, $o->getTaintedVar($Key));
		}

		$NewTaintedVars = array_merge($ExistingTaintedVars, array(
			'ana' => uniqid('val1:'),
			'are' => uniqid('val2:'),
			'mere' => uniqid('val3:')
		));
		$o->setTaintedVars($NewTaintedVars);

		foreach ($NewTaintedVars as $Key => $Value) {
			$this->assertEquals($Value, $o->getTaintedVar($Key));
		}

		$RandomInexistentVars = array(
			uniqid('key_') => uniqid('val:'),
			uniqid('key_') => uniqid('val:'),
		);

		foreach ($RandomInexistentVars as $Key => $Value) {
			$this->assertNotEquals($Value, $o->getTaintedVar($Key));
			$this->assertNull($o->getTaintedVar($Key));
		}
	}
}
