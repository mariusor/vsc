<?php
namespace tests\presentation\responses\HttpResponse;
use vsc\presentation\responses\HttpResponse;

/**
 * @covers \vsc\presentation\responses\HttpResponse::getOutput()
 */
class getOutput extends \BaseUnitTest
{
	public function testGetEmptyOutput () {
		$state = new HttpResponse();
		$t = $state->getOutput();

		$this->assertEquals($t, '');
	}
}
