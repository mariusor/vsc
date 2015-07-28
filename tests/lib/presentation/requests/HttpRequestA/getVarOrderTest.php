<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getVarOrder()
 */
class getVarOrder extends \PHPUnit_Framework_TestCase
{
	public function testGetVarOrder() {
		$sOrder = ini_get('variables_order');
		for ($i = 0; $i < 4; $i++) {
			// reversing the order
			$varOrder[$i] = substr($sOrder, $i, 1);
		}

		$this->assertSame($varOrder, PopulatedRequest::getVarOrder());
	}
}
