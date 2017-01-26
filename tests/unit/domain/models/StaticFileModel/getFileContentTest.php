<?php
namespace tests\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::getFileContent()
 */
class getFileContent extends \BaseUnitTest
{
	public function testBasic__get()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(file_get_contents(__FILE__), $o->getFileContent());
	}
}
