<?php
namespace tests\res\domain\models\ErrorModel;
use vsc\domain\models\ErrorModel;
use vsc\Exception;

/**
 * @covers \vsc\domain\models\ErrorModel::getException()
 */
class getException extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$e = new Exception('test');
		$o = new ErrorModel($e);
		$this->assertSame($e, $o->getException());
	}
}
