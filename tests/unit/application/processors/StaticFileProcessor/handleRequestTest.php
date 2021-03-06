<?php
namespace tests\application\processors\StaticFileProcessor;
use vsc\domain\models\StaticFileModel;
use vsc\infrastructure\vsc;
use vsc\application\processors\StaticFileProcessor;

/**
 * @covers \vsc\application\processors\StaticFileProcessor::handleRequest()
 */
class handleRequest extends \BaseUnitTest
{
	public function testBasicHandleRequest()
	{
		date_default_timezone_set('UTC');
		$o = new StaticFileProcessor();

		$oModel = $o->handleRequest(vsc::getEnv()->getHttpRequest());
		$this->assertInstanceOf(StaticFileModel::class, $oModel);
	}
}
