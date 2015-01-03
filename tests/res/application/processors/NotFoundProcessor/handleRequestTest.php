<?php
namespace tests\res\application\processors\NotFoundProcessor;

/**
 * @covers \vsc\application\processors\NotFoundProcessor::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
