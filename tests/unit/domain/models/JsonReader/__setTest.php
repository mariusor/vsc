<?php
namespace tests\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * @covers \vsc\domain\models\JsonReader::__set()
 */
class __set extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new JsonReader();
		$k = 'myKey';
		$v = uniqid($k . ':');
		$o->__set($k, $v);
		$this->assertEquals($v, $o->__get($k));
	}
}
