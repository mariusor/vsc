<?php
namespace tests\res\infrastructure\Null;
use vsc\Exception;
use vsc\ExceptionUnimplemented;
use vsc\infrastructure\Null;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\Null::__toString()
 */
class __toString extends \PHPUnit_Framework_TestCase
{
	public function test__setDev ()
	{
		$null = new Null();

		$env = new vsc_underTest___toString();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$null->__set ( uniqid('test'), uniqid('val:'));
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$null->test = uniqid('val:');
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}
}

class vsc_underTest___toString extends vsc {
	private $isDevelopmentEnviroment = false;

	public function setIsDevelopment ($isDevelopment) {
		$this->isDevelopmentEnviroment = $isDevelopment;
	}

	/**
	 * @return boolean
	 */
	public function isDevelopment () {
		return $this->isDevelopmentEnviroment;
	}
}

