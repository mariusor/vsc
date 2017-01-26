<?php
namespace tests\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::parseToEntity()
 */
class parseToEntity extends \BaseUnitTest
{
	public function testParseToEntityEmptyItemsFromEmptyDOMNodeList()
	{
		$a = new \DOMNodeList();
		$o = new RssReader();
		$o->parseToEntity($a);
		$this->assertEmpty($o->getItems());
	}
}
