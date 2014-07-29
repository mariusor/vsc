<?php
vsc\import ('presentation');
vsc\import ('responses');
class vscHttpResponseTest extends PHPUnit_Framework_TestCase {
	public function setUp () {
		// @todo
	}

	public function tearDown () {
		// @todo
	}

	public function testSetGetStatus () {
		$state = new vscHttpResponse();
		$iStatus = 300;

		try {
			$state->setStatus($iStatus);
		} catch (vscException $e) {
			$this->assertInstanceOf('vscExceptionResponse', $e);
			$this->assertEquals('['.$iStatus.'] is not a valid  status', $e->getMessage());
		}
		$iStatus = 304;
		$state->setStatus($iStatus);
		$this->assertEquals($iStatus, $state->getStatus());
	}

	public function testSetGetLocation () {
		$state = new vscHttpResponse();
		$sLocation = '/';

		$state->setLocation($sLocation);
		$this->assertEquals($sLocation, $state->getLocation());
	}

	public function testGetOutput () {
		$state = new vscHttpResponse();
		$t = $state->getOutput();

		$this->assertEquals($t, '');
	}
}
