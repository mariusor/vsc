<?php
namespace tests\application\processors\RPCProcessorA;
use vsc\application\processors\RPCProcessorA;

/**
 * @covers \vsc\application\processors\RPCProcessorA::hasRPCMethod()
 */
class hasRPCMethod extends \BaseUnitTest
{
	public function testUseless()
	{
		$service = new ServiceMock();
		$_SERVER['CONTENT_TYPE'] = 'application/json';

		$o = new RPCProcessorA_underTest_hasRPCMethod();
		$this->assertFalse($o->hasRPCMethod($service, 'invalidCall'));
		$this->assertTrue($o->hasRPCMethod($service, 'getStatus'));
	}
}

class ServiceMock {
	public function getStatus () {}
}

class RPCProcessorA_underTest_hasRPCMethod extends RPCProcessorA {
	public function getRPCInterface($sNameSpace = null)
	{
		// TODO: Implement getRPCInterface() method.
	}
}
