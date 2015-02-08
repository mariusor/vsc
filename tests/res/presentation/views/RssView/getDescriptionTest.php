<?php
namespace tests\res\presentation\views\RssView;
use vsc\presentation\views\RssView;

/**
 * @covers \vsc\presentation\views\RssView::getDescription()
 */
class getDescription extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new RssView();
		$this->assertEmpty($o->getDescription());
	}
}
