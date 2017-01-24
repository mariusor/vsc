<?php
namespace tests\res\domain\models\ErrorModel;
use vsc\domain\models\ErrorModel;
use vsc\ExceptionError;

/**
 * @covers \vsc\domain\models\ErrorModel::setException()
 */
class setException extends \BaseUnitTest
{
	public function testBasicSetException()
	{
		$e = new \Exception('initial', 0);
		$o = new ErrorModel($e);
		$this->assertSame($e, $o->getException());

		$r = new ExceptionError('test', 1);
		$o->setException($r);
		$this->assertSame($r, $o->getException());
	}
}
