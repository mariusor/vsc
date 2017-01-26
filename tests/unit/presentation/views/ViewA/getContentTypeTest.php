<?php
namespace tests\presentation\views\ViewA;
use mocks\presentation\views\testView;

/**
 * @covers \vsc\presentation\views\ViewA::getContentType()
 */
class getContentType extends \BaseUnitTest
{
	public function testGetContentTypeEmpty()
	{
		$o = new testView();

		$this->assertEmpty($o->getContentType());
	}
}
