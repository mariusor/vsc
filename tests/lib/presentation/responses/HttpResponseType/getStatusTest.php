<?php
namespace tests\lib\presentation\responses\HttpResponseType;

/**
 * @covers the public method HttpResponseType::getStatus()
 */
class getStatus extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
