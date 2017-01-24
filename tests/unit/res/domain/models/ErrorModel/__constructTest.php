<?php
namespace tests\res\domain\models\ErrorModel;
use vsc\Exception;
use vsc\domain\models\ErrorModel;

/**
 * @covers \vsc\domain\models\ErrorModel::__construct()
 */
class __construct extends \BaseUnitTest
{
	public function testCorrectInstantiationWithException()
	{
		$e = new Exception('test');
		$o = new ErrorModel($e);
		$this->assertSame($e, $o->getException());
	}

	public function testCorrectInstantiationWithoutException()
	{
		$o = new ErrorModel();
		$this->assertNull($o->getException());
	}
}
