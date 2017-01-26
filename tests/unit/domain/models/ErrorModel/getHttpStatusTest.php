<?php
namespace tests\domain\models\ErrorModel;
use vsc\domain\models\ErrorModel;
use vsc\presentation\responses\HttpResponseType;

/**
 * @covers \vsc\domain\models\ErrorModel::getHttpStatus()
 */
class getHttpStatus extends \BaseUnitTest
{
	public function testModelHTTPStatusSameAsExceptionHTTPStatus()
	{
		$message = uniqid('test:');
		$e = new \ErrorException($message, HttpResponseType::INTERNAL_ERROR);
		$o = new ErrorModel($e);
		$this->assertEquals(HttpResponseType::INTERNAL_ERROR, $o->getHttpStatus());
	}
}
