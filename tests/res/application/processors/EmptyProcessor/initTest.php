<?php
namespace tests\res\application\processors\EmptyProcessor;

/**
 * @covers the public method EmptyProcessor::init()
 */
class init extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
