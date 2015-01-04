<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::getStatus()
 */
class getStatus extends \PHPUnit_Framework_TestCase
{
	/**
	 * @throws \vsc\presentation\responses\ExceptionResponse::setStatus
	 * @throws \vsc\presentation\responses\ExceptionResponse::getStatus
	 */
	public function testSetGetStatus () {
		$state = new HttpResponseA_underTest_getStatus();

		$this->assertNull($state->getStatus());

		$testValue = HttpResponseType::ACCEPTED;
		$state->setStatus($testValue);
		$this->assertEquals($testValue, $state->getStatus());

		$iStatus = 300; // invalid status

		try {
			$state->setStatus($iStatus);
		} catch (\Exception $e) {
			$this->assertInstanceOf(\vsc\presentation\responses\ExceptionResponse::class, $e);
			$this->assertEquals('['.$iStatus.'] is not a valid  status', $e->getMessage());
		}

		$iStatus = HttpResponseType::SEE_OTHER;
		$state->setStatus($iStatus);
		$this->assertEquals($iStatus, $state->getStatus());
	}
}

class HttpResponseA_underTest_getStatus extends HttpResponseA {}
