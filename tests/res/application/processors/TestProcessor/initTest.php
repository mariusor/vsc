<?php
namespace tests\res\application\processors\TestProcessor;

/**
 * @covers \vsc\application\processors\TestProcessor::init()
 */
class init extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
