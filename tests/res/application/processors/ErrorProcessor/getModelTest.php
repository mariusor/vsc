<?php
namespace tests\res\application\processors\ErrorProcessor;

/**
 * @covers the public method ErrorProcessor::getModel()
 */
class getModel extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
