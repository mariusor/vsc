<?php
namespace tests\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::setFileName()
 */
class setFileName extends \BaseUnitTest
{
	public function testBasicSetFilename()
	{
		$o = new StaticFileModel();
		$o->setFileName(__FILE__);
		$this->assertEquals(__FILE__, $o->getFileName());
	}
}
