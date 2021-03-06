<?php
namespace tests\Exception;
use PHPUnit\Framework\TestCase;
use vsc\Exception;

/**
 * @covers \vsc\Exception::isValid()
 */
class isValid extends TestCase
{
	public function testValidException() {
		$E = new Exception();
		$this->assertTrue (Exception::isValid ($E));
		$this->assertEquals (Exception::isValid ($E), ($E instanceof Exception));
		$this->assertInstanceOf(Exception::class, $E);
		$this->assertInstanceOf(\Exception::class, $E);
	}

	public function testInvalidException() {
		$F = new \Exception();
		$this->assertFalse(Exception::isValid($F));
		$this->assertEquals(Exception::isValid($F), ($F instanceof Exception));
		$this->assertInstanceOf(\Exception::class, $F);
	}
}
