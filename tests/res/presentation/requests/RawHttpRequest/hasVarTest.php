<?php
namespace tests\res\presentation\requests\RawHttpRequest;
use fixtures\presentation\requests\PopulatedRESTRequest;

/**
 * @covers \vsc\presentation\requests\RawHttpRequest::hasVar()
 */
class hasVar extends \PHPUnit_Framework_TestCase
{
	public function testHasVar_ParentVar()
	{
		$o = new PopulatedRESTRequest();

		$o->setContentType('application/json');

		$this->assertFalse($o->hasVar('gigel'));
		$this->assertFalse($o->hasVar('random'));

		// GET var
		$this->assertTrue($o->hasVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($o->hasVar('ana'));
		$this->assertTrue($o->hasVar('test'));
		// POST var
		$this->assertTrue($o->hasVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($o->hasVar('ana'));
		// Cookie var
		$this->assertTrue($o->hasVar('user')); // 'user' => 'asddsasdad234'

		PopulatedRESTRequest::startSession();

		$o->setSessionVar('ala', uniqid('ala:'));
		$o->setSessionVar('bala', '##');
		// Session var
		$this->assertTrue($o->hasVar('ala')); // 'ala' =>  uniqid('ala:'), 'bala' => '##'
		$this->assertTrue($o->hasVar('bala'));
	}
}
