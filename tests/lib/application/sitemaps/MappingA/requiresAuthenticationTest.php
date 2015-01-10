<?php
namespace tests\lib\application\sitemaps\MappingA;
use vsc\application\sitemaps\MappingA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\application\sitemaps\MappingA::requiresAuthentication()
 */
class requiresAuthentication extends \PHPUnit_Framework_TestCase
{
	public function testRequiresAuthenticationBasic()
	{
		$o = new MappingA_underTest_requiresAuthentication();
		$o->setAuthenticationType(HttpAuthenticationA::BASIC);
		$this->assertTrue($o->requiresAuthentication());

		$o->setAuthenticationType(HttpAuthenticationA::DIGEST);
		$this->assertTrue($o->requiresAuthentication());

		$o->setAuthenticationType(HttpAuthenticationA::NONE);
		$this->assertFalse($o->requiresAuthentication());
	}

	public function testRequiresAuthenticationComposite()
	{
		$o = new MappingA_underTest_requiresAuthentication();
		$o->setAuthenticationType(HttpAuthenticationA::BASIC | HttpAuthenticationA::DIGEST);
		$this->assertTrue($o->requiresAuthentication());

		$o->setAuthenticationType(HttpAuthenticationA::NONE | HttpAuthenticationA::BASIC | HttpAuthenticationA::DIGEST);
		$this->assertTrue($o->requiresAuthentication());
	}
}

class MappingA_underTest_requiresAuthentication extends MappingA {
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
