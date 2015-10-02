<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::hasVar()
 */
class hasVar extends \PHPUnit_Framework_TestCase
{
	public function tearDown() {
		@session_destroy();
	}

	public function testHasVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertTrue($o->hasVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($o->hasVar('ana'));
		$this->assertTrue($o->hasVar('test'));
		// POST var
		$this->assertTrue($o->hasVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($o->hasVar('ana'));
		// Cookie var
		$this->assertTrue($o->hasVar('user')); // 'user' => 'asddsasdad234'

		PopulatedRequest::startSession();

		$o->setSessionVar('ala', uniqid('ala:'));
		$o->setSessionVar('bala', '##');
		// Session var
		$this->assertTrue($o->hasVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($o->hasVar('bala'));
	}
}
