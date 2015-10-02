<?php
namespace lib\infrastructure\urls\UrlParserA;

use mocks\infrastructure\urls\UrlParserFixture;

/**
 * Class setPathTest
 * @package lib\infrastructure\urls\UrlParserA
 * @covers \vsc\infrastructure\urls\UrlParserA::setPath()
 */
class setPathTest extends \PHPUnit_Framework_TestCase
{

	public function testSetPathWithFolderWithoutProperEnding()
	{
		$o = new UrlParserFixture();
		$path = uniqid('/ana/are/mere/');

		$o->setPath($path);

		$this->assertEquals($path, $o->getPath($path));
	}

	public function testSetPathWithFolderWithProperEnding()
	{
		$o = new UrlParserFixture();
		$path = uniqid('/ana/') . '/';

		$o->setPath($path);

		$this->assertEquals($path, $o->getPath());
	}

	public function testSetPathWithFileWithExtension()
	{
		$o = new UrlParserFixture();
		$path = uniqid('/ana/') . '/index.html';

		$o->setPath($path);

		$this->assertEquals($path, $o->getPath());
	}

	public function testSetRealPath()
	{
		$o = new UrlParserFixture();

		$o->setPath(__FILE__);

		$this->assertEquals(__FILE__, $o->getPath());
	}
}

