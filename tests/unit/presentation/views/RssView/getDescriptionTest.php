<?php
namespace tests\presentation\views\RssView;
use vsc\presentation\views\RssView;

/**
 * @covers \vsc\presentation\views\RssView::getDescription()
 */
class getDescription extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new RssView();
		$this->assertEmpty($o->getDescription());
	}
}
