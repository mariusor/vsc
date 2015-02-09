<?php
namespace tests\res\domain\models\RssReader;
use vsc\domain\models\RssReader;

/**
 * @covers \vsc\domain\models\RssReader::setItems()
 */
class setItems extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$a = [];
		$o = new RssReader();
		$o->setItems($a);

		$this->assertEquals($a, $o->getItems());
	}
}
