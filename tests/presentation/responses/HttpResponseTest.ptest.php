<?php
use vsc\presentation\responses\HttpResponse;
use vsc\Exception;

class HttpResponseTest extends \PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetGetStatus () {
		$state = new HttpResponse();
		$iStatus = 300;

		try {
			$state->setStatus($iStatus);
		} catch (Exception $e) {
			$this->assertInstanceOf('\\vsc\\presentation\\responses\\ExceptionResponse', $e);
			$this->assertEquals('['.$iStatus.'] is not a valid  status', $e->getMessage());
		}
		$iStatus = 304;
		$state->setStatus($iStatus);
		$this->assertEquals($iStatus, $state->getStatus());
	}

	public function testSetGetLocation () {
		$state = new HttpResponse();
		$sLocation = '/';

		$state->setLocation($sLocation);
		$this->assertEquals($sLocation, $state->getLocation());
	}

	public function testGetOutput () {
		$state = new HttpResponse();
		$t = $state->getOutput();

		$this->assertEquals($t, '');
	}
}
