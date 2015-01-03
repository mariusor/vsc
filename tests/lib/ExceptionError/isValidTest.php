<?php
namespace tests\lib\ExceptionError;

/**
 * @covers \vsc\Exception::isValid()
 */
class isValid extends \PHPUnit_Framework_TestCase
{
	public function testValidErrorException() {
		$E = new \vsc\ExceptionError();
		$this->assertTrue (\vsc\ExceptionError::isValid ($E));
		$this->assertEquals (\vsc\ExceptionError::isValid ($E), ($E instanceof \vsc\ExceptionError));
		$this->assertInstanceOf(\vsc\ExceptionError::class, $E);
		$this->assertInstanceOf(\ErrorException::class, $E);
	}

	public function testInvalidErrorException() {
		$F = new \ErrorException();
		$this->assertFalse(\vsc\ExceptionError::isValid($F));
		$this->assertEquals(\vsc\ExceptionError::isValid($F), ($F instanceof \vsc\ExceptionError));
		$this->assertInstanceOf(\ErrorException::class, $F);
	}
}
