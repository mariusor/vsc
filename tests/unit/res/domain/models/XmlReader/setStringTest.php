<?php
namespace tests\res\domain\models\XmlReader;
use vsc\domain\models\XmlReader;

/**
 * @covers \vsc\domain\models\XmlReader::setString()
 */
class setString extends \BaseUnitTest
{
	public function testBasicSetString()
	{
		$value = 'test';
		$o = new XmlReader();
		$o->setString($value);

		$this->assertEquals($value, $o->getString());
	}
}
