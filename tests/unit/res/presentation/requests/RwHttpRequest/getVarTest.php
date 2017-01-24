<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getVar()
 */
class getVar extends \BaseUnitTest
{
	public function testGetGetVarCorrect() {
		$o = new PopulatedRequest();
		$this->assertEquals($_GET['ana'], $o->getVar('ana'));
	}

	public function testGetGetVarIncorrect() {
		$o = new PopulatedRequest();
		$this->assertEquals($o->getVar('asdf'), '');
	}
}
