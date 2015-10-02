<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;

/**
 * @covers \vsc\application\sitemaps\MappingA::removeHeader()
 */
class removeHeader extends \PHPUnit_Framework_TestCase
{
	public function testBasicRemoveHeader()
	{
		$o = new MappingA_underTest_removeHeader();
		$this->assertArrayHasKey('Accept', $o->getHeaders());

		$o->removeHeader('Accept');

		$headers = $o->getHeaders();
		$this->assertArrayHasKey('Accept', $headers);
		$this->assertNull($headers['Accept']);
	}
}

class MappingA_underTest_removeHeader extends MappingA {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::addHeader('Accept', 'application/json');
		parent::__construct($sPath, $sRegex);
	}
}
