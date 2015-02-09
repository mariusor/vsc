<?php
namespace tests\res\domain\models\ErrorModel;
use vsc\Exception;
use vsc\domain\models\ErrorModel;

/**
 * @covers \vsc\domain\models\ErrorModel::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$e = new Exception('test');
		$o = new ErrorModel($e);
		$this->assertSame($e, $o->getException());
	}
}
