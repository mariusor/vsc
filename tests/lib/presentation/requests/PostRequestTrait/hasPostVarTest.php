<?php
namespace tests\lib\presentation\requests\PostRequestTrait;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequestTrait::hasPostVar()
 */
class hasPostVar extends \PHPUnit_Framework_TestCase
{
	public function testHasPostVar() {
		$o = new PopulatedRequest();
		// POST var
		$this->assertTrue($o->hasPostVar('postone')); // 'postone' => 'are', 'ana' => ''
		$this->assertTrue($o->hasPostVar('ana'));
	}

}
