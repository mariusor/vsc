<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use mocks\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getLastParameter()
 */
class getLastParameter extends \PHPUnit_Framework_TestCase
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
