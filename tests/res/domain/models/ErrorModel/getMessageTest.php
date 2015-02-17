<?php
namespace tests\res\domain\models\ErrorModel;
use vsc\domain\models\ErrorModel;

/**
 * @covers \vsc\domain\models\ErrorModel::getMessage()
 */
class getMessage extends \PHPUnit_Framework_TestCase
{
	public function testModelMessageSameAsExceptionMessage()
	{
		$message = uniqid('test:');
		$o = new ErrorModel(new \Exception($message, 1));

		$this->assertEquals($message, $o->getMessage());
	}
}
