<?php
namespace tests\domain\models\JsonRPCResponse;
use vsc\domain\models\JsonRPCResponse;

/**
 * @covers \vsc\domain\models\JsonRPCResponse::getProperties()
 */
class getProperties extends \BaseUnitTest
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

	public function testGetPropertiesWithProtected()
	{
		$jsonRPC = [
			'id' => null,
			'result' => null,
			'error' => null,
			'prot' => 123
		];
		$o = new JsonRPCResponse_underTest_getProperties();
		$this->assertEquals($jsonRPC, $o->getProperties(true));
	}
}

class JsonRPCResponse_underTest_getProperties extends JsonRPCResponse {
	protected $prot = 123;
	public function getProperties ($bIncludeProtected = false) {
		return parent::getProperties($bIncludeProtected);
	}
}
