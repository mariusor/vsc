<?php
namespace tests\res\application\processors\EmptyProcessor;

/**
 * @covers \vsc\application\processors\EmptyProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
