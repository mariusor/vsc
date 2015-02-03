<?php
namespace tests\lib\application\processors\RPCProcessorA;

/**
 * @covers \vsc\application\processors\RPCProcessorA::getRequest()
 */
class getRequest extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete('The RPC section is not done');
	}
}
