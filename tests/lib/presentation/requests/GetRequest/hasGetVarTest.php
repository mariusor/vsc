<?php
namespace tests\lib\presentation\requests\GetRequest;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\GetRequest::hasGetVar()
 */
class hasGetVar extends \PHPUnit_Framework_TestCase
{
	public function testHasGetVar() {
		$o = new PopulatedRequest();
		// GET var
		$this->assertTrue($o->hasGetVar('cucu')); // 'cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123
		$this->assertTrue($o->hasGetVar('ana'));
		$this->assertTrue($o->hasGetVar('test'));
	}
}
