<?php
namespace tests\res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * @covers \vsc\domain\models\JsonReader::__get()
 */
class __get extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new JsonReader();
		$this->assertEmpty($o->__get('test'));
		$this->assertEmpty($o->__get());
	}
}
