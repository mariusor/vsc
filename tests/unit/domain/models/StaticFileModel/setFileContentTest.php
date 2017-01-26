<?php
namespace tests\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::setFileContent()
 */
class setFileContent extends \BaseUnitTest
{
	public function testBasicSetFileContent()
	{
		$value = uniqid('test:');
		$o = new StaticFileModel();
		$o->setFileContent($value);
		$this->assertEquals($value, $o->getFileContent());
	}
}
