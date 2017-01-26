<?php
namespace tests\lib\application\sitemaps\MappingA;
use mocks\application\sitemaps\ModuleMapFixture;
use vsc\application\sitemaps\ResourceMapTrait;

/**
 * @covers \vsc\application\sitemaps\ResourceMapTrait::removeHeader()
 */
class removeHeader extends \BaseUnitTest
{
	public function testBasicRemoveHeader()
	{
		$o = new ResourceMapTrait_underTest_removeHeader();
		$this->assertArrayHasKey('Accept', $o->getHeaders());

		$o->removeHeader('Accept');

		$headers = $o->getHeaders();
		$this->assertArrayHasKey('Accept', $headers);
		$this->assertNull($headers['Accept']);
	}
}

class ResourceMapTrait_underTest_removeHeader extends ModuleMapFixture {
	use ResourceMapTrait;

	public function __construct () {
		parent::__construct();
		$this->addHeader('Accept', 'application/json');
	}
}
