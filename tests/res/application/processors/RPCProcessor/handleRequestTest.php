<?php
namespace tests\res\application\processors\RPCProcessor;

/**
 * @covers \vsc\application\processors\RPCProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
