<?php
namespace lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * Class isServerErrorTest
 * @package lib\presentation\responses\HttpResponseA
 * @covers \vsc\presentation\responses\HttpResponseA::isServerError()
 */
class isServerErrorTest extends \PHPUnit_Framework_TestCase
{
	public function providerForHttpStatuses ()
	{
		$aStatuses = HttpResponseType::getList();
		$return = array();
		foreach ($aStatuses as $iStatus => $sStatus) {
			$return[] = [$iStatus];
		}
		return $return;
	}

	/**
	 * @param int $status
	 * @throws \vsc\presentation\responses\ExceptionResponse
	 * @dataProvider providerForHttpStatuses
	 */
	public function testBasicisServerError($status) {
		$o = new HttpResponseA_underTest_isServerError();
		$o->setStatus($status);

		if ($status >= 500 && $status < 600) {
			$this->assertTrue($o->isServerError());
		} else {
			$this->assertFalse($o->isServerError());
		}
	}
}

class HttpResponseA_underTest_isServerError extends HttpResponseA {}
