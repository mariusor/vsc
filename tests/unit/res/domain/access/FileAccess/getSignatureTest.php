<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getSignature()
 */
class getSignature extends \PHPUnit_Framework_TestCase
{
	public function testGetSignatureSameAsMD5OfPathDate()
	{
		$o = new FileAccess('');
		$this->assertEquals(md5 (__FILE__ . date('Ymd')), $o->getSignature(__FILE__));
	}
}
