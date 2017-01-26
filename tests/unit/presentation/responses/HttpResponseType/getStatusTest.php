<?php
namespace tests\presentation\responses\HttpResponseType;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseType::getStatus()
 */
class getStatus extends \BaseUnitTest
{

	public function providerForTestGetStatus ()
	{
		$aStatuses = HttpResponseType::getList();
		$return = array();
		foreach ($aStatuses as $iStatus => $sStatus) {
			$return[] = [$iStatus, $sStatus];
		}
		return $return;
	}

	/**
	 * @dataProvider providerForTestGetStatus
	 * @param $iStatus
	 * @param $sStatusText
	 */
	public function testGetStatus($iStatus, $sStatusText) {
		$this->assertEquals($sStatusText, HttpResponseType::getStatus($iStatus));
	}
}
