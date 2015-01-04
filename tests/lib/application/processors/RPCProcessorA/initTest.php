<?php
namespace tests\lib\application\processors\RPCProcessorA;
use lib\rest\application\processors\RESTProcessorA\RESTProcessorA_underTest_validContentType;
use vsc\application\processors\RPCProcessorA;
use vsc\infrastructure\vsc;
use vsc\presentation\requests\RawHttpRequest;

/**
 * @covers \vsc\application\processors\RPCProcessorA::init()
 */
class init extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$this->markTestIncomplete('The RPC section is not done');
//		vsc::getEnv()->setHttpRequest(new RawHttpRequest_underTest_init());
//		$o = new RPCProcessorA_underTest_init();
//		$this->assertNull($o->init());
	}
}

class RawHttpRequest_underTest_init extends RawHttpRequest {
	public function getContentType() {
		return 'application/json';
	}
}

class RPCProcessorA_underTest_init extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}
