<?php
namespace tests\res\domain\models\XmlReader;
use vsc\domain\models\XmlReader;

/**
 * @covers \vsc\domain\models\XmlReader::getDom()
 */
class getDom extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new XmlReader();
		$this->assertNull($o->getDom());
	}
}
