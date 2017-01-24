<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::setTaintedVars()
 */
class setTaintedVars extends \BaseUnitTest
{
	public function testSetTaintedVars() {
		$o = new PopulatedRequest();
		$ExistingTaintedVars = array(
			'module'	=> 'test',
			'cucu'		=> 'mucu',
			'height'	=> 143
		);
		$this->assertEquals($ExistingTaintedVars, $o->getTaintedVars());

		$NewTaintedVars = array(
			'ana' => uniqid('val1:'),
			'are' => uniqid('val2:'),
			'mere' => uniqid('val3:')
		);
		$o->setTaintedVars($NewTaintedVars);
		$this->assertNotEquals($ExistingTaintedVars,$o->getTaintedVars());
		$this->assertEquals(array_merge($ExistingTaintedVars, $NewTaintedVars),$o->getTaintedVars());
	}

}
