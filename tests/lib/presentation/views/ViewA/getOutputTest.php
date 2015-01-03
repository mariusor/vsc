<?php
namespace tests\lib\presentation\views\ViewA;

/**
 * @covers \vsc\presentation\views\ViewA::getOutput()
 */
class getOutput extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
