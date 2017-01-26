<?php
namespace tests\presentation\views\ViewA;
use mocks\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getTemplate()
 */
class getTemplate extends \BaseUnitTest
{
	public function testGetTemplateEmpty ()
	{
		$o = new testView();

		$path = $o->getTemplate();
		$this->assertEmpty($path);
	}
}
