<?php
namespace tests\infrastructure\Object;
use vsc\infrastructure\Base;
use vsc\infrastructure\vsc;
use vsc\infrastructure\BaseObject;
use vsc\ExceptionUnimplemented;
use vsc\Exception;

/**
 * @covers \vsc\infrastructure\BaseObject::__callStatic()
 */
class __callStatic extends \BaseUnitTest
{
	public function test__callStaticDev () {
		$env = new vsc_underTest___callStatic();
		$env->setIsDevelopment(true);

		vsc::setInstance($env);

		try {
			Base_Object_underTest___callStatic::__callStatic('test', array());
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
		try {
			Base_Object_underTest___callStatic::testCall('test');
		} catch (\Exception $e) {
			$this->assertInstanceOf(ExceptionUnimplemented::class, $e);
			$this->assertInstanceOf(Exception::class, $e);
		}
	}

	public function test__callStaticNotDev () {
		$env = new vsc_underTest___callStatic();
		$env->setIsDevelopment(false);

		vsc::setInstance($env);

		$this->assertInstanceOf(Base::class, Base_Object_underTest___callStatic::__callStatic('test', array()));
		$this->assertInstanceOf(Base::class, Base_Object_underTest___callStatic::testCall('test'));
	}
}


class Base_Object_underTest___callStatic extends BaseObject {}

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
