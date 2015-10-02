<?php
namespace tests\res\infrastructure\Object;
use vsc\infrastructure\Base;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Object;
use vsc\ExceptionUnimplemented;
use vsc\Exception;

/**
 * @covers \vsc\infrastructure\Object::__callStatic()
 */
class __callStatic extends \PHPUnit_Framework_TestCase
{
	public function test__callStaticDev () {
		$env = new vsc_underTest___callStatic();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			Object_underTest___callStatic::__callStatic('test', array());
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			Object_underTest___callStatic::testCall('test');
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__callStaticNotDev () {
		$env = new vsc_underTest___callStatic();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Base::class, Object_underTest___callStatic::__callStatic('test', array()));
		$this->assertInstanceOf(Base::class, Object_underTest___callStatic::testCall('test'));
	}
}


class Object_underTest___callStatic extends Object {}

class vsc_underTest___callStatic extends vsc {
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
