<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers the public method ErrorProcessor::getErrorCode()
 */
class getErrorCode extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
