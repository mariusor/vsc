<?php
namespace tests\application\processors\StaticFileProcessor;
use vsc\application\processors\StaticFileProcessor;
use vsc\infrastructure\vsc;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\application\processors\StaticFileProcessor::setFilePath()
 */
class setFilePath extends \BaseUnitTest
{
	public function testBasicSetPath()
	{
		$o = new StaticFileProcessor();
		$o->setFilePath(__FILE__);

		$oModel = $o->handleRequest(vsc::getEnv()->getHttpRequest());
		$this->assertInstanceOf(StaticFileModel::class, $oModel);
		$this->assertEquals(__FILE__, $oModel->getFilePath());
	}
}
