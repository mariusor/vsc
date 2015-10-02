<?php
namespace tests\lib\presentation\responses\HttpResponseType;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseType::getStatus()
 */
class getStatus extends \PHPUnit_Framework_TestCase
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
