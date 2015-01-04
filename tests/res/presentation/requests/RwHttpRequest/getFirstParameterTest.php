<?php
namespace tests\res\presentation\requests\RwHttpRequest;
use fixtures\presentation\requests\PopulatedRequest;

/**
 * @covers \vsc\presentation\requests\RwHttpRequest::getFirstParameter()
 */
class getFirstParameter extends \PHPUnit_Framework_TestCase
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
