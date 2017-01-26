<?php
namespace tests\presentation\views\XhtmlView;
use vsc\presentation\views\XhtmlView;

/**
 * @covers \vsc\presentation\views\XhtmlView::getMetaHeaders()
 */
class getMetaHeaders extends \BaseUnitTest
{
	public function testEmptyAtInitialization()
	{
		$o = new XhtmlView();
		$this->assertEquals([], $o->getMetaHeaders());
	}
}
