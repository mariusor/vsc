<?php
namespace tests\lib\presentation\views\ViewA;
use mocks\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getMainTemplate()
 */
class getMainTemplate extends \BaseUnitTest
{
	public function testGetMainTemplateEmpty ()
	{
		$o = new testView();

		$path = $o->getMainTemplate();
		$this->assertEmpty($path);
	}
}
