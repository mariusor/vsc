<?php
namespace tests\presentation\views\RssView;
use vsc\presentation\views\RssView;

/**
 * @covers \vsc\presentation\views\RssView::getLanguage()
 */
class getLanguage extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new RssView();
		$this->assertEmpty($o->getLanguage());
	}
}
