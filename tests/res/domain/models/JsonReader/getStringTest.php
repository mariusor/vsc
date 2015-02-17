<?php
namespace tests\res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * @covers \vsc\domain\models\JsonReader::getString()
 */
class getString extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new JsonReader();

		$this->assertEmpty($o->getString());
	}
}
