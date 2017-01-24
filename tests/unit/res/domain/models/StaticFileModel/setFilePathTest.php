<?php
namespace tests\res\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::setFilePath()
 */
class setFilePath extends \BaseUnitTest
{
	public function testBasicSetFilePath()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(__FILE__, $o->getFilePath());
	}
}
