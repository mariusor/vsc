<?php
namespace tests\res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * @covers \vsc\domain\models\JsonReader::setString()
 */
class setString extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetString()
	{
		$t = '[]';

		$o = new JsonReader();
		$o->setString($t);

		$this->assertEquals($t, $o->getString());
	}
}
