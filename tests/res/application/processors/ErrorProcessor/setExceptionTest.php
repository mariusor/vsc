<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers the public method ErrorProcessor::setException()
 */
class setException extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
