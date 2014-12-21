<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers the public method ErrorProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
