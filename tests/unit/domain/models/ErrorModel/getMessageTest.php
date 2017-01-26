<?php
namespace tests\domain\models\ErrorModel;
use vsc\domain\models\ErrorModel;

/**
 * @covers \vsc\domain\models\ErrorModel::getMessage()
 */
class getMessage extends \BaseUnitTest
{
	public function testModelMessageSameAsExceptionMessage()
	{
		$message = uniqid('test:');
		$o = new ErrorModel(new \Exception($message, 1));

		$this->assertEquals($message, $o->getMessage());
	}
}
