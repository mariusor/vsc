<?php
namespace tests\res\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::getFileContent()
 */
class getFileContent extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(file_get_contents(__FILE__), $o->getFileContent());
	}
}
