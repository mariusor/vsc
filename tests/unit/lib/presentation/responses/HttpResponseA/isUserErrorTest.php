<?php
namespace lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * Class isUserErrorTest
 * @package lib\presentation\responses\HttpResponseA
 * @covers \vsc\presentation\responses\HttpResponseA::isUserError()
 */
class isUserErrorTest extends \PHPUnit_Framework_TestCase
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
	public function testBasicisUserError($status) {
		$o = new HttpResponseA_underTest_isUserError();
		$o->setStatus($status);

		if ($status >= 400 && $status < 500) {
			$this->assertTrue($o->isUserError());
		} else {
			$this->assertFalse($o->isUserError());
		}
	}
}

class HttpResponseA_underTest_isUserError extends HttpResponseA {}
