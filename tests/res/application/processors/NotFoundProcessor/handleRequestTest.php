<?php
namespace tests\res\application\processors\NotFoundProcessor;

/**
 * @covers the public method NotFoundProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
