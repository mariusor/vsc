<?php
namespace tests\lib\presentation\requests\PostRequest;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\PostRequest::hasPostVar()
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
