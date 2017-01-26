<?php
namespace tests\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getFirstParameter()
 */
class getFirstParameter extends \BaseUnitTest
{
	public function testGetFirstParameter() {
		$o = new PopulatedRequest();
		$this->assertEquals('module',$o->getFirstParameter());

		$o->setTaintedVars(array(
			'ana' => uniqid('val:')
		));

		$this->assertEquals('ana',$o->getFirstParameter());
	}
}
