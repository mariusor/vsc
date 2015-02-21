<?php
namespace tests\lib\presentation\requests\GetRequestT;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\GetRequestT::getGetVar()
 */
class getGetVar extends \PHPUnit_Framework_TestCase
{
	public function tearDown() {
		@session_destroy();
	}

	public function testGetVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertEquals('pasare', $o->getVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertEquals('are', $o->getVar('ana'));
		$this->assertEquals('', $o->getVar('mere'));
		$this->assertEquals(123, $o->getVar('test'));
		// POST var
		$this->assertEquals('are', $o->getVar('postone')); // 'postone' => 'are', 'ana' => ''
		// Cookie var
		$this->assertEquals('asddsasdad234', $o->getVar('user')); // 'user' => 'asddsasdad234'

		// Session var
		PopulatedRequest::startSession();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		$this->assertEquals($_SESSION['ala'], $o->getVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertEquals($_SESSION['bala'], $o->getVar('bala'));
	}
}
