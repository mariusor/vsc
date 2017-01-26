<?php
namespace tests\application\sitemaps\MappingA;
use mocks\application\sitemaps\MapFixture;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\application\sitemaps\MappingA::setAuthenticationType()
 */
class setAuthenticationType extends \BaseUnitTest
{
	public function testSetAuthenticationTypeBasic()
	{
		$o = new MappingA_underTest_setAuthenticationType();
		$o->setAuthenticationType(HttpAuthenticationA::BASIC);
		$this->assertEquals(HttpAuthenticationA::BASIC, $o->getAuthenticationType());

		$o->setAuthenticationType(HttpAuthenticationA::DIGEST);
		$this->assertEquals(HttpAuthenticationA::DIGEST, $o->getAuthenticationType());

		$o->setAuthenticationType(HttpAuthenticationA::NONE);
		$this->assertEquals(HttpAuthenticationA::NONE, $o->getAuthenticationType());
	}

	public function testSetAuthenticationTypeComposite()
	{
		$o = new MappingA_underTest_setAuthenticationType();
		$o->setAuthenticationType(HttpAuthenticationA::BASIC | HttpAuthenticationA::DIGEST);
		$this->assertEquals(HttpAuthenticationA::BASIC | HttpAuthenticationA::DIGEST, $o->getAuthenticationType());

		$o->setAuthenticationType(HttpAuthenticationA::NONE | HttpAuthenticationA::BASIC | HttpAuthenticationA::DIGEST);
		$this->assertEquals(HttpAuthenticationA::NONE | HttpAuthenticationA::BASIC | HttpAuthenticationA::DIGEST, $o->getAuthenticationType());
	}
}

class MappingA_underTest_setAuthenticationType extends MapFixture {
	public function __construct ($sPath = null, $sRegex = null) {
		if (is_null($sPath)) {
			$sPath = __FILE__;
		}
		if (is_null($sRegex)) {
			$sRegex = '.*';
		}
		parent::__construct($sPath, $sRegex);
	}
}
