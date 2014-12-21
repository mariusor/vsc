<?php
namespace tests\res\application\processors\RPCProcessor;

/**
 * @covers the public method RPCProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
