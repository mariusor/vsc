<?php
namespace tests\lib\application\processors\RPCProcessorA;
use vsc\application\processors\RPCProcessorA;

/**
 * @covers \vsc\application\processors\RPCProcessorA::callRPCMethod()
 */
class callRPCMethod extends \BaseUnitTest
{
	public function testUseless()
	{
		$_SERVER['CONTENT_TYPE'] = 'application/json';
		$o = new RPCProcessorA_underTest_callRPCMethod();
		$this->assertNull($o->callRPCMethod());
	}
}

class RPCProcessorA_underTest_callRPCMethod extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}
