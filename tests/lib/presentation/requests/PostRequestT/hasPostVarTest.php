<?php
namespace tests\lib\presentation\requests\PostRequestT;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequestT::hasPostVar()
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
