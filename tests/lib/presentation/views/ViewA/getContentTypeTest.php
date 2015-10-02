<?php
namespace tests\lib\presentation\views\ViewA;
use mocks\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getContentType()
 */
class getContentType extends \PHPUnit_Framework_TestCase
{
	public function testGetContentTypeEmpty()
	{
		$o = new testView();

		$this->assertEmpty($o->getContentType());
	}
}
