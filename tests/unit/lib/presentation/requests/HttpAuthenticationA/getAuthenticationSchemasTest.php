<?php
namespace tests\lib\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\HttpAuthenticationA;

/**
 * @covers \vsc\presentation\requests\HttpAuthenticationA::getAuthenticationSchemas()
 */
class getAuthenticationSchemas extends \BaseUnitTest
{
	public function testGetAuthenticationSchemasWithDifferentTypes ()
	{
		$BasicAuthentication = ['Basic'];
		$DigestAuthentication = ['Digest'];

		$this->assertEquals ([], HttpAuthenticationA::getAuthenticationSchemas(HttpAuthenticationA::NONE));
		$this->assertEquals ($BasicAuthentication, HttpAuthenticationA::getAuthenticationSchemas(HttpAuthenticationA::BASIC));
		$this->assertEquals ($DigestAuthentication, HttpAuthenticationA::getAuthenticationSchemas(HttpAuthenticationA::DIGEST));
		$this->assertEquals (
			array_merge($BasicAuthentication, $DigestAuthentication),
			HttpAuthenticationA::getAuthenticationSchemas(HttpAuthenticationA::DIGEST | HttpAuthenticationA::BASIC)
		);
	}
}
