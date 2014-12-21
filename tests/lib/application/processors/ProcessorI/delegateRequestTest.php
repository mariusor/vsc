<?php
namespace tests\lib\application\processors\ProcessorI;

/**
 * @covers the  method ProcessorI::delegateRequest()
 */
class delegateRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
