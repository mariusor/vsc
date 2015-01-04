<?php
namespace tests\lib\presentation\views\ViewA;
use fixtures\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getMainTemplate()
 */
class getMainTemplate extends \PHPUnit_Framework_TestCase
{
	public function testGetMainTemplateEmpty ()
	{
		$o = new testView();

		$path = $o->getMainTemplate();
		$this->assertEmpty($path);
	}
}
