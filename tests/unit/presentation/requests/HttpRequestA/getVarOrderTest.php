<?php
namespace tests\presentation\requests\HttpRequestA;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getVarOrder()
 */
class getVarOrder extends \BaseUnitTest
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
