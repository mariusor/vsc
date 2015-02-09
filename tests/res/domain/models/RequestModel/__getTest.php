<?php
namespace tests\res\domain\models\RequestModel;
use vsc\domain\models\RequestModel;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\domain\models\RequestModel::__get()
 */
class __get extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$_GET = [];
		$_POST = [];
		$_SERVER = [];
		$_SESSION = [];
		$_COOKIE = [];

		$key = 'test';
		vsc::setInstance(new vsc());

		$o = new RequestModel();
		$this->assertEquals('<span style="font-size:0.8em">['.$key.' does not exist in the request]</span>',$o->__get($key));
	}
}
