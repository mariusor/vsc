<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::getSignature()
 */
class getSignature extends \BaseUnitTest
{
	public function testGetSignatureSameAsMD5OfPathDate()
	{
		$o = new FileAccess('');
		$this->assertEquals(md5 (__FILE__ . date('Ymd')), $o->getSignature(__FILE__));
	}
}
