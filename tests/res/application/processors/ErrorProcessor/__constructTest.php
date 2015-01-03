<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers \vsc\application\processors\ErrorProcessor::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
