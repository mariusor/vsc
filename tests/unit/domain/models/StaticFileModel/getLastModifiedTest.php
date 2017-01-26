<?php
namespace tests\domain\models\StaticFileModel;
use vsc\domain\models\StaticFileModel;

/**
 * @covers \vsc\domain\models\StaticFileModel::getLastModified()
 */
class getLastModified extends \BaseUnitTest
{
	public function testGetLastModifiedMatchesFilemtimeOfFile()
	{
		$o = new StaticFileModel();
		$o->setFilePath(__FILE__);
		$this->assertEquals(date('Y-m-d G:i:s', filemtime(__FILE__)), $o->getLastModified());
	}
}
