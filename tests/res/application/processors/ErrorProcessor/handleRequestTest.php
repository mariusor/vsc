<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers \vsc\application\processors\ErrorProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
