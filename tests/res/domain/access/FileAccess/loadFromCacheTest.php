<?php
namespace tests\res\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::loadFromCache()
 */
class loadFromCache extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$file = 'test';
		$value = uniqid('test:');
		$o = new FileAccess('');
		$o->setCachePath(VSC_FIXTURE_PATH);
		$o->cacheFile($file, $value);

		$this->assertEquals($value, $o->loadFromCache($file));
		unlink(VSC_FIXTURE_PATH . $o->getSignature($file));
	}
}
