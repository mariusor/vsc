<?php
namespace tests\res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * @covers \vsc\domain\models\JsonReader::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$o = new JsonReader();

		$this->assertInstanceOf(JsonReader::class, $o);
	}
}
