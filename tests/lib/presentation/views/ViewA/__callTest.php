<?php
namespace tests\lib\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
