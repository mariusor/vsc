<?php
namespace tests\lib\application\processors\ErrorProcessorI;

/**
 * @covers the  method ErrorProcessorI::getErrorCode()
 */
class getErrorCode extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
