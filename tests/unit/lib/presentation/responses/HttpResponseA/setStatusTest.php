<?php
namespace tests\lib\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseA;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseA::setStatus()
 */
class setStatus extends \BaseUnitTest
{

	public function providerForTestBasicSetStatus ()
	{
		$aStatuses = HttpResponseType::getList();
		$return = array();
		foreach ($aStatuses as $iStatus => $sStatus) {
			$return[] = [$iStatus];
		}
		return $return;
	}

	/**
	 * @dataProvider providerForTestBasicSetStatus
	 * @param integer $iStatus
	 * @throws \vsc\presentation\responses\ExceptionResponse
	 */
	public function testBasicSetStatus($iStatus)
	{
		$o = new HttpResponseA_underTest_setStatus();
		$o->setStatus($iStatus);
		$this->assertEquals($iStatus, $o->getStatus());
	}
}

class HttpResponseA_underTest_setStatus extends HttpResponseA {}
