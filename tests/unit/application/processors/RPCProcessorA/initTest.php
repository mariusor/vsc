<?php
namespace tests\application\processors\RPCProcessorA;
use lib\rest\application\processors\RESTProcessorA\RESTProcessorA_underTest_validContentType;
use vsc\application\processors\RPCProcessorA;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\application\processors\RPCProcessorA::init()
 */
class init extends \BaseUnitTest
{
	public function testUseless()
	{
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$req = new RawHttpRequest_underTest_init();
		vsc::getEnv()->setHttpRequest($req);

		$o = new RPCProcessorA_underTest_init();
		$this->assertNull($o->init());
		$this->assertEquals(1, $o->getResponse()->id);
	}
}

class RawHttpRequest_underTest_init extends RawHttpRequest {
	public function getRawInput () {
		$req = [
			'id' => 1,
			'method' => 'test',
			'rpc' => 2.0,
			'params' => []
		];
		return json_encode($req);
	}
}

class RPCProcessorA_underTest_init extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}
