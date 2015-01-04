<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getVar()
 */
class getVar extends \PHPUnit_Framework_TestCase
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
