<?php
namespace tests\res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;
use vsc\infrastructure\Base;

/**
 * @covers \vsc\domain\models\JsonReader::__get()
 */
class __get extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new JsonReader();
		$this->assertInstanceOf(Base::class, $o->__get('test'));
		$this->assertInstanceOf(Base::class, $o->__get());
	}
}
