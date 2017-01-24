<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::buildObj()
 */
class buildObj extends \BaseUnitTest
{
	public function testBuildObjectWithEmptyXml()
	{
		$o = new RssReader();
		$o->setString('<xml />');
		$o->buildObj();
		$this->assertEmpty($o->getItems());
	}
}
