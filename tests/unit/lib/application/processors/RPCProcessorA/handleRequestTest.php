<?php
namespace tests\lib\application\processors\RPCProcessorA;
use vsc\application\processors\RPCProcessorA;
use vsc\domain\models\JsonRPCResponse;
use vsc\presentation\requests\RwHttpRequest;

/**
 * @covers \vsc\application\processors\RPCProcessorA::handleRequest()
 */
class handleRequest extends \PHPUnit_Framework_TestCase
{
	public function testUseless()
	{
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$o = new RPCProcessorA_underTest_handleRequest();
		$this->assertInstanceOf(JsonRPCResponse::class, $o->handleRequest(new RwHttpRequest()));
	}
}

class RPCProcessorA_underTest_handleRequest extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}