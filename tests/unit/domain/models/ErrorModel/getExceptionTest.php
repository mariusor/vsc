<?php
namespace tests\domain\models\ErrorModel;
use vsc\domain\models\ErrorModel;
use vsc\Exception;

/**
 * @covers \vsc\domain\models\ErrorModel::getException()
 */
class getException extends \BaseUnitTest
{
	public function testGetExceptionAfterModelInitializedWithException()
	{
		$e = new Exception('test');
		$o = new ErrorModel($e);
		$this->assertSame($e, $o->getException());
	}
}
