<?php
namespace tests\ExceptionError;
use vsc\ExceptionError;

/**
 * @covers \vsc\ExceptionError::isValid()
 */
class isValid extends \BaseUnitTest
{
	public function testValidErrorException() {
		$E = new ExceptionError();
		$this->assertTrue (ExceptionError::isValid ($E));
		$this->assertEquals (ExceptionError::isValid ($E), ($E instanceof ExceptionError));
		$this->assertInstanceOf(ExceptionError::class, $E);
		$this->assertInstanceOf(\ErrorException::class, $E);
	}

	public function testInvalidErrorException() {
		$F = new \ErrorException();
		$this->assertFalse(ExceptionError::isValid($F));
		$this->assertEquals(ExceptionError::isValid($F), ($F instanceof ExceptionError));
		$this->assertInstanceOf(\ErrorException::class, $F);
	}
}
