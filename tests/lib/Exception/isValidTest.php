<?php
namespace tests\lib\Exception;

/**
 * @coversgit \vsc\Exception::isValid()
 */
class isValid extends \PHPUnit_Framework_TestCase
{
	public function testValidException() {
		$E = new \vsc\Exception();
		$this->assertTrue (\vsc\Exception::isValid ($E));
		$this->assertEquals (\vsc\Exception::isValid ($E), ($E instanceof \vsc\Exception));
		$this->assertInstanceOf(\vsc\Exception::class, $E);
		$this->assertInstanceOf(\Exception::class, $E);
	}

	public function testInvalidException() {
		$F = new \Exception();
		$this->assertFalse(\vsc\Exception::isValid($F));
		$this->assertEquals(\vsc\Exception::isValid($F), ($F instanceof \vsc\Exception));
		$this->assertInstanceOf(\Exception::class, $F);
	}
}
