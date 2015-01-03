<?php
namespace tests\lib\ExceptionError;
/**
 * @covers \vsc\ExceptionError::getSeverityString()
 */
class getSeverityString extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetSeverityString () {
		$E = new \vsc\ExceptionError();
		$Mirror = new \ReflectionClass($E);
		$MirrorProperty = $Mirror->getProperty('aErrorTypes');
		$MirrorProperty->setAccessible(true);

		$Codes = $MirrorProperty->getValue($E);

		foreach ($Codes as $key => $Code) {
			$CodeValue = constant($Code);

			$this->assertNotEmpty($CodeValue);
			$this->assertEquals($CodeValue, $key);

			$F = new \vsc\ExceptionError('test' . $key, $key, $key);
			$this->assertEquals($Code, $F->getSeverityString());

			$G = new \vsc\ExceptionError('test' . $key, $key, $CodeValue);
			$this->assertEquals($Code, $G->getSeverityString());
		}
	}
}
