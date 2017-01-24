<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequestTrait;

/**
 * @covers vsc\presentation\requests\ServerRequestTrait::loadCachingHeaders()
 */
class loadCachingHeadersTest extends \BaseUnitTest
{
	public function testBasicLoad() {
		$aServer = [
			'HTTP_IF_MODIFIED_SINCE' => uniqid('mod_since:'),
			'HTTP_IF_NONE_MATCH' => uniqid('none_match:'),
		];

		$o = new ServerRequest_underTest_loadCachingHeaders();
		$o->loadCachingHeaders($aServer);

		$this->assertEquals($aServer['HTTP_IF_MODIFIED_SINCE'], $o->getIfModifiedSince());
		$this->assertEquals($aServer['HTTP_IF_NONE_MATCH'], $o->getIfNoneMatch());
	}
}

class ServerRequest_underTest_loadCachingHeaders {
	use ServerRequestTrait {loadCachingHeaders as public;}

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		return true;
	}
}
