<?php
namespace tests\res\domain\models\JsonRPCResponse;
use vsc\domain\models\JsonRPCResponse;

/**
 * @covers \vsc\domain\models\JsonRPCResponse::getProperties()
 */
class getProperties extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetProperties()
	{
		$jsonRPC = [
			'id' => null,
			'result' => null,
			'error' => null
		];
		$o = new JsonRPCResponse_underTest_getProperties();
		$this->assertEquals($jsonRPC, $o->getProperties());
	}
}

class JsonRPCResponse_underTest_getProperties extends JsonRPCResponse {
	public function getProperties ($bIncludeNonPublic = false) {
		return parent::getProperties($bIncludeNonPublic);
	}
}
