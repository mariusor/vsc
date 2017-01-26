<?php
namespace tests\presentation\responses\HttpResponseType;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseType::getList()
 */
class getList extends \BaseUnitTest
{
	public function testBasicGetList() {
		$Mirror = new \ReflectionClass(HttpResponseType::class);
		$MirrorProperty = $Mirror->getProperty('aStatusList');
		$MirrorProperty->setAccessible(\ReflectionProperty::IS_PUBLIC);
		$aStatuses = $MirrorProperty->getValue();

		$this->assertEquals($aStatuses, HttpResponseType::getList());
	}
}
