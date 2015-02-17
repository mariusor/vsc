<?php
namespace tests\res\domain\models\XmlReader;
use vsc\domain\models\XmlReader;

/**
 * @covers \vsc\domain\models\XmlReader::buildObj()
 */
class buildObj extends \PHPUnit_Framework_TestCase
{
	public function testBuildObjectFromIncompleteXml()
	{

		$value = '<t>test</t>';
		$o = new XmlReader();
		$o->setString($value);

		$o->buildObj();

		$this->assertInstanceOf(\DOMDocument::class, $o->getDom());
		$this->assertContains($value, $o->getDom()->saveXML()); // the output xml contains the XML header
	}
}
