<?php
namespace tests\application\processors\EmptyProcessor;
use vsc\application\processors\EmptyProcessor;
use vsc\domain\models\EmptyModel;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\application\processors\EmptyProcessor::handleRequest()
 */
class handleRequest extends \BaseUnitTest
{
	public function testBasicHandleRequest()
	{
		$o = new EmptyProcessor();

		$oModel = $o->handleRequest(vsc::getEnv()->getHttpRequest());
		$this->assertInstanceOf(EmptyModel::class, $oModel);
		$this->assertEquals('[ null ]', $oModel->getPageTitle());
		$this->assertEquals('[ NULL ]', $oModel->getPageContent());
	}
}
