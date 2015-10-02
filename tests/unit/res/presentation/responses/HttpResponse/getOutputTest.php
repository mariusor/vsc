<?php
namespace tests\res\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponse;

/**
 * @covers \vsc\presentation\responses\HttpResponse::getOutput()
 */
class getOutput extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptyOutput () {
		$state = new HttpResponse();
		$t = $state->getOutput();

		$this->assertEquals($t, '');
	}
}
