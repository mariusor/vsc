<?php
namespace tests\res\application\processors\TestProcessor;

/**
 * @covers the public method TestProcessor::init()
 */
class init extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
