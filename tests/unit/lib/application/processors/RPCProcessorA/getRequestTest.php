<?php
namespace tests\lib\application\processors\RPCProcessorA;
use vsc\application\processors\RPCProcessorA;
use vsc\domain\models\JsonRPCRequest;

/**
 * @covers \vsc\application\processors\RPCProcessorA::getRequest()
 */
class getRequest extends \BaseUnitTest
{
	public function testUseless()
	{
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$o = new RPCProcessorA_underTest_getRequest();
		$this->assertInstanceOf(JsonRPCRequest::class, $o->getRequest());
	}
}

class RPCProcessorA_underTest_getRequest extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}
