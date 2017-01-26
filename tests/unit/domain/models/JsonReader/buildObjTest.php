<?php
namespace res\domain\models\JsonReader;
use vsc\domain\models\JsonReader;

/**
 * Class buildObjTest
 * @package res\domain\models\JsonReader
 * @covers \vsc\domain\models\JsonReader::buildObj()
 */
class buildObjTest extends \BaseUnitTest {
	public function testBasicBuildObject() {
		$o = new JsonReader();
		$k = 'myKey';
		$v = uniqid('value:');
		$test = [$k => $v];
		$jsTest = json_encode($test);
		$o->setString($jsTest);

		$o->buildObj();

		$this->assertInstanceOf(JsonReader::class, $o);
		$this->assertJsonStringEqualsJsonString($jsTest, $o->getString());

		$this->assertNotNull($o->$k);
		$this->assertEquals($v, $o->$k);
	}
}
