<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::parseToEntity()
 */
class parseToEntity extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$a = new \DOMNodeList();
		$o = new RssReader();
		$o->parseToEntity($a);
		$this->assertEmpty($o->getItems());
	}
}
