<?php
namespace tests\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getLastParameter()
 */
class getLastParameter extends \BaseUnitTest
{
	public function testGetLastParameter() {
		$o = new PopulatedRequest();
		$this->assertEquals('height',$o->getLastParameter());

		$o->setTaintedVars(array(
			'ana' => uniqid('val:'),
		));

		$this->assertEquals('height',$o->getLastParameter());
	}
}
