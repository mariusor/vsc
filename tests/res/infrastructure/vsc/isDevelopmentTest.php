<?php
namespace tests\res\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::isDevelopment()
 */
class isDevelopment extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
