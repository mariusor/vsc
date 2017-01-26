<?php
namespace tests\presentation\views\ViewA;
use mocks\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getViewFolder()
 */
class getViewFolder extends \BaseUnitTest
{
	public function testGetViewFolderEmpty()
	{
		$o = new testView();

		$this->assertEmpty($o->getViewFolder());
	}

	public function testGetViewFolder()
	{
		$o = new testView();

		$t = 'test';
		$o->setFolder($t);
		$this->assertEquals($t, $o->getViewFolder());
	}
}
