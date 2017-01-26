<?php
namespace tests\domain\access\FileAccess;
use vsc\domain\access\FileAccess;

/**
 * @covers \vsc\domain\access\FileAccess::loadFromCache()
 */
class loadFromCache extends \BaseUnitTest
{
	public function testLoadFromCacheWorks()
	{
		$file = 'test';
		$value = uniqid('test:');
		$o = new FileAccess('');
		$o->setCachePath(VSC_MOCK_PATH);
		$o->cacheFile($file, $value);

		$this->assertEquals($value, $o->loadFromCache($file));
		unlink(VSC_MOCK_PATH . $o->getSignature($file));
	}
}
