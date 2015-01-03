<?php
namespace tests\res\application\processors\TestProcessor;

/**
 * @covers \vsc\application\processors\TestProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
