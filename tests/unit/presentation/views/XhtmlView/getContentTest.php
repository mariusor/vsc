<?php
namespace tests\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::getContent()
 */
class getContent extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new XhtmlView();
		$this->assertEquals('', $o->getContent());
	}
}
