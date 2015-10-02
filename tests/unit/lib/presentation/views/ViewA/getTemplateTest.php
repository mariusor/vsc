<?php
namespace tests\lib\presentation\views\ViewA;
use mocks\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getTemplate()
 */
class getTemplate extends \PHPUnit_Framework_TestCase
{
	public function testGetTemplateEmpty ()
	{
		$o = new testView();

		$path = $o->getTemplate();
		$this->assertEmpty($path);
	}
}
