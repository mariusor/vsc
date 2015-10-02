<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getTaintedVars()
 */
class getTaintedVars extends \PHPUnit_Framework_TestCase
{
	public function testGetTaintedVars() {
		$o = new PopulatedRequest();

		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$this->assertEquals($ExistingTaintedVars, $o->getTaintedVars());

		$NewTaintedVars = array_merge($ExistingTaintedVars, array(
			'ana' => uniqid('val1:'),
			'are' => uniqid('val2:'),
			'mere' => uniqid('val3:')
		));
		$o->setTaintedVars($NewTaintedVars);

		$this->assertEquals($NewTaintedVars, $o->getTaintedVars());

		$RandomInexistentVars = array(
			uniqid('key_') => uniqid('val:'),
			uniqid('key_') => uniqid('val:'),
			'tst' => uniqid('val:'),
		);

		foreach ($RandomInexistentVars as $Key => $Value) {
			$this->assertArrayNotHasKey($Key, $o->getTaintedVars());
		}
	}
}
