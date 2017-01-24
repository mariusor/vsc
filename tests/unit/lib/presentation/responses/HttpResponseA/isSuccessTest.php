<?php
namespace lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * Class isSuccessTest
 * @package lib\presentation\responses\HttpResponseA
 * @covers \vsc\presentation\responses\HttpResponseA::isSuccess()
 */
class isSuccessTest extends \BaseUnitTest
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
	public function testBasicIsSuccess($status) {
		$o = new HttpResponseA_underTest_isSuccess();
		$o->setStatus($status);

		if ($status == HttpResponseType::OK) {
			$this->assertTrue($o->isSuccess());
		} else {
			$this->assertFalse($o->isSuccess());
		}
	}
}

class HttpResponseA_underTest_isSuccess extends HttpResponseA {}
