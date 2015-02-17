<?php
namespace tests\res\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::setLastModified()
 */
class setLastModified extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetLastModifed()
	{
		$now = date('Y-m-d');
		$o = new StaticFileModel();
		$o->setLastModified($now);
		$this->assertEquals($now, $o->getLastModified());
	}
}
