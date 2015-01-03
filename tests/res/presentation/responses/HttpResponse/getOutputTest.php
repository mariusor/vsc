<?php
namespace tests\res\presentation\responses\HttpResponse;

/**
 * @covers \vsc\presentation\responses\HttpResponse::getOutput()
 */
class getOutput extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
