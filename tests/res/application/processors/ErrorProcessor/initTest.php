<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers \vsc\application\processors\ErrorProcessor::init()
 */
class init extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
