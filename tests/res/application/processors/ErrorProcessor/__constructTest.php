<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers the public method ErrorProcessor::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
