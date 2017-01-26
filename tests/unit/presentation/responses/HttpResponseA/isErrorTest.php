<?php
namespace lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * Class isErrorTest
 * @package lib\presentation\responses\HttpResponseA
 * @covers \vsc\presentation\responses\HttpResponseA::isError()
 */
class isErrorTest extends \BaseUnitTest
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
	public function testBasicisError($status) {
		$o = new HttpResponseA_underTest_isError();
		$o->setStatus($status);

		if ($status >= 400 && $status < 600) {
			$this->assertTrue($o->isError());
		} else {
			$this->assertFalse($o->isError());
		}
	}
}

class HttpResponseA_underTest_isError extends HttpResponseA {}
