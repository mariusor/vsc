<?php
namespace tests\lib\presentation\responses\HttpResponseType;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseType::getStatus()
 */
class getStatus extends \PHPUnit_Framework_TestCase
{
	public function testGetStatus() {
		$Mirror = new \ReflectionClass(HttpResponseType::class);
		$MirrorProperty = $Mirror->getProperty('aStatusList');
		$MirrorProperty->setAccessible(\ReflectionProperty::IS_PUBLIC);
		$aStatuses = $MirrorProperty->getValue();

		foreach ($aStatuses as $iStatus => $sStatusText) {
			$this->assertEquals($aStatuses[$iStatus], HttpResponseType::getStatus($iStatus));
		}
	}
}
