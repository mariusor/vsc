<?php
namespace tests\lib\presentation\requests\SessionRequestTrait;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::hasSessionVar()
 */
class hasSessionVar extends \PHPUnit_Framework_TestCase
{
	public function tearDown() {
		@session_destroy();
	}
	public function testHasSessionVar() {
		PopulatedRequest::startSession();

		$o = new PopulatedRequest();

		$o->setSessionVar('ala', uniqid('ala:'));
		$o->setSessionVar('bala', '##');
		// Session var
		$this->assertTrue($o->hasSessionVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($o->hasSessionVar('bala'));
	}

}
