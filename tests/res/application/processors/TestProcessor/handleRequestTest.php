<?php
namespace tests\res\application\processors\TestProcessor;

/**
 * @covers the public method TestProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
