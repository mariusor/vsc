<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::__construct()
 */
class __construct extends \PHPUnit_Framework_TestCase
{
	public function testBasic__construct()
	{
		$_GET = [];
		$_POST = [];
		$_REQUEST = [];
		$_COOKIE = [];
		$_SESSION = [];
		$_SERVER = [];
		$_FILES = [];
		$o = new HttpRequestA_underTest__construct();
		$this->assertInstanceOf(HttpRequestA::class, $o);
		$this->assertEmpty($o->getGetVars());
		$this->assertEmpty($o->getPostVars());
		$this->assertEmpty($o->getCookieVars());
		$this->assertEmpty($o->getSessionVars());
		$this->assertEmpty($o->getHttpAccept());
		$this->assertEmpty($o->getHttpAcceptCharset());
		$this->assertEmpty($o->getHttpAcceptEncoding());
		$this->assertEmpty($o->getHttpAcceptLanguage());
		$this->assertEmpty($o->getHttpMethod());
		$this->assertEmpty($o->getHttpReferer());
		$this->assertEmpty($o->getHttpUserAgent());
		$this->assertEmpty($o->getIfModifiedSince());
		$this->assertEmpty($o->getIfNoneMatch());
		$this->assertEmpty($o->getContentType());
		$this->assertEmpty($o->getDoNotTrack());
		$this->assertEmpty($o->hasAuthenticationData());
		$this->assertEmpty($o->hasFiles());
	}
}

class HttpRequestA_underTest__construct extends HttpRequestA {}
