<?php
namespace tests\res\domain\models\XmlReader;
use vsc\domain\models\XmlReader;

/**
 * @covers \vsc\domain\models\XmlReader::getString()
 */
class getString extends \PHPUnit_Framework_TestCase
{
	public function testGetString()
	{
		$value = 'test';
		$o = new XmlReader();
		$o->setString($value);

		$this->assertEquals($value, $o->getString());
	}
}
