<?php
namespace tests\lib\application\processors\ProcessorA;

/**
 * @covers the public method ProcessorA::delegateRequest()
 */
class delegateRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
