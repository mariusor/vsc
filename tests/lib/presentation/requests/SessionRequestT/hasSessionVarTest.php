<?php
namespace tests\lib\presentation\requests\SessionRequestT;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequestT::hasSessionVar()
 */
class hasSessionVar extends \PHPUnit_Framework_TestCase
{
	public function tearDown() {
		@session_destroy();
	}
	public function testHasSessionVar() {
		PopulatedRequest::startSession();

		$o = new PopulatedRequest();

		$_SESSION['ala'] = uniqid('ala:');
		$_SESSION['bala'] = '##';
		// Session var
		$this->assertTrue($o->hasSessionVar('ala')); // 'ala' => uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($o->hasSessionVar('bala'));
	}

}
