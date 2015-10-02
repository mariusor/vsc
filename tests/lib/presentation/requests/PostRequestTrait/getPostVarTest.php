<?php
namespace tests\lib\presentation\requests\PostRequestTrait;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequestTrait::getPostVar()
 */
class getPostVar extends \PHPUnit_Framework_TestCase
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
