<?php
namespace tests\lib\presentation\requests\PostRequest;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequest::getPostVar()
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
