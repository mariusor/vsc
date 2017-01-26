<?php
namespace tests\presentation\requests\PostRequestTrait;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequestTrait::getPostVar()
 */
class getPostVar extends \BaseUnitTest
{
	public function testGetPostVarIncorrect() {
		$o = new PopulatedRequest();
		$this->assertNotEquals($_POST['ana'], $o->getVar('ana'));
	}

	public function testGetPostVarCorrect() {
		$o = new PopulatedRequest();
		$this->assertEquals($_POST['postone'], $o->getVar('postone'));
	}
}
