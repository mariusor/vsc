<?php
namespace tests\res\infrastructure\Object;
use vsc\infrastructure\Null;
use vsc\infrastructure\Object;
use vsc\infrastructure\vsc;
use fixtures\infrastructure\ObjectFixture;
use fixtures\infrastructure\FixtureEnv;
use vsc\ExceptionUnimplemented;
use vsc\Exception;

/**
 * @covers \vsc\infrastructure\Object::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test Object::__call()
	 */
	public function test__callDev() {
		$null = new Object_underTest___call();

		$env = new vsc_underTest___call();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			$null->__call ( uniqid('test'), array());
		} catch (Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			$null->test();
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	/**
	 * @test Object::__call()
	 */
	public function test__callNotDev () {
		$null = new Object_underTest___call();

		$env = new vsc_underTest___call();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Null::class, $null->__call ( uniqid('test'), array()));
		$this->assertInstanceOf(Null::class, $null->test());
	}
}

class Object_underTest___call extends Object {}

class vsc_underTest___call extends vsc {
	private $isDevelopmentEnviroment = false;
	private $isCli = false;

	public function setIsDevelopment ($isDevelopment) {
		$this->isDevelopmentEnviroment = $isDevelopment;
	}

	/**
	 * @return boolean
	 */
	public function isDevelopment () {
		return $this->isDevelopmentEnviroment;
	}

	public function setIsCli ($IsIt) {
		$this->isCli = $IsIt;
	}

	protected function _isCli () {
		return $this->isCli;
	}
}
