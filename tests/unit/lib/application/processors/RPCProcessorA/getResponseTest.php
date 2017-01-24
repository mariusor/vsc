<?php
namespace tests\lib\application\processors\RPCProcessorA;
use vsc\application\processors\RPCProcessorA;
use vsc\domain\models\JsonRPCRequest;
use vsc\domain\models\JsonRPCResponse;

/**
 * @covers \vsc\application\processors\RPCProcessorA::getResponse()
 */
class getResponse extends \BaseUnitTest
{
	public function testUseless()
	{
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$o = new RPCProcessorA_underTest_getResponse();
		$this->assertInstanceOf(JsonRPCResponse::class, $o->getResponse());
	}
}

class RPCProcessorA_underTest_getResponse extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}
