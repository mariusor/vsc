<?php
namespace tests\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * @covers \vsc\domain\models\JsonReader::getString()
 */
class getString extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new JsonReader();

		$this->assertEmpty($o->getString());
	}
}
