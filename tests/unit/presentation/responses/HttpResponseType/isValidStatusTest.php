<?php
namespace tests\presentation\responses\HttpResponseType;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\presentation\responses\HttpResponseType::isValidStatus()
 */
class isValidStatus extends \BaseUnitTest
{
	public function testBasicIsValidStatus ()
	{
		$Mirror = new \ReflectionClass(HttpResponseType::class);
		$MirrorProperty = $Mirror->getProperty('aStatusList');
		$MirrorProperty->setAccessible(\ReflectionProperty::IS_PUBLIC);
		$aStatuses = $MirrorProperty->getValue();

		for ($i = 0; $i < 600; $i++) {
			if (array_key_exists($i, $aStatuses)) {
				$this->assertTrue(HttpResponseType::isValidStatus($i));
			} else {
				$this->assertFalse(HttpResponseType::isValidStatus($i));
			}
		}
	}
}
