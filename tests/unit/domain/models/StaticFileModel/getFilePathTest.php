<?php
namespace tests\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::getFilePath()
 */
class getFilePath extends \BaseUnitTest
{
	public function testBasicGetFilePath()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(__FILE__, $o->getFilePath());
	}
}
