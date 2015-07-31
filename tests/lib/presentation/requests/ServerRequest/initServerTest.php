<?php
namespace lib\presentation\requests\ServerRequest;

use vsc\presentation\requests\HttpAuthenticationA;
use vsc\presentation\requests\ServerRequest;

/**
 * Class initServerTest
 * @package lib\presentation\requests\ServerRequest
 */
class initServerTest extends \PHPUnit_Framework_TestCase
{

	public function testBasicEmptyEverything () {
		$aServer = [];
		$o = new ServerRequest_underTest_initServer();
		$o->initServer($aServer);

		$this->assertEquals('', $o->getHttpMethod());
		$this->assertEquals([], $o->getHttpAccept());
		$this->assertEquals([], $o->getHttpAcceptEncoding());
		$this->assertEquals([], $o->getHttpAcceptLanguage());
		$this->assertEquals([], $o->getHttpAcceptCharset());
		$this->assertEquals('', $o->getHttpReferer());
		$this->assertEquals('', $o->getHttpUserAgent());
		$this->assertEquals('', $o->getContentType());
		$this->assertEquals('', $o->getDoNotTrack());
		$this->assertEquals('', $o->getServerName());
		$this->assertEquals('', $o->getServerProtocol());
		$this->assertEquals('', $o->getIfModifiedSince());
		$this->assertEquals('', $o->getIfNoneMatch());
	}

	public function testFullRequest () {
		$aServer = [
			'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'HTTP_ACCEPT_CHARSET' => 'iso-8859-5, unicode-1-1;q=0.8',
			'HTTP_ACCEPT_ENCODING' => 'gzip, deflate, sdch',
			'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8,de;q=0.6',
			'HTTP_IF_MODIFIED_SINCE' => 'Sat, 29 Oct 1994 19:43:31 GMT',
			'HTTP_IF_NONE_MATCH' => '737060cd8c284d8af7ad3082f209582d',
			'HTTP_USER_AGENT' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.125 Safari/537.36',
			'HTTP_REFERER' => '/',
			'HTTP_DNT' => 1,
			'CONTENT_TYPE' => 'text/plain',
			'SERVER_SOFTWARE' => 'Apache/2.4.16 (Unix) PHP/5.6.11',
			'SERVER_NAME' => 'mdreader.git',
			'SERVER_PROTOCOL' => 'HTTP/1.1',
			'REQUEST_METHOD' => 'GET',
		];
		$o = new ServerRequest_underTest_initServer();
		$o->initServer($aServer);

		$this->assertEquals($aServer['REQUEST_METHOD'], $o->getHttpMethod());
		$this->assertEquals([
			'text/html',
			'application/xhtml+xml',
			'application/xml;q=0.9',
			'image/webp',
			'*/*;q=0.8'
		], $o->getHttpAccept());
		$this->assertEquals(['gzip', 'deflate', 'sdch'], $o->getHttpAcceptEncoding());
		$this->assertEquals(['en-US','en;q=0.8','de;q=0.6'], $o->getHttpAcceptLanguage());
		$this->assertEquals(['iso-8859-5', 'unicode-1-1;q=0.8'], $o->getHttpAcceptCharset());
		$this->assertEquals($aServer['HTTP_REFERER'], $o->getHttpReferer());
		$this->assertEquals($aServer['HTTP_USER_AGENT'], $o->getHttpUserAgent());
		$this->assertEquals($aServer['CONTENT_TYPE'], $o->getContentType());
		$this->assertEquals($aServer['HTTP_DNT'], $o->getDoNotTrack());
		$this->assertEquals($aServer['SERVER_NAME'], $o->getServerName());
		$this->assertEquals($aServer['SERVER_PROTOCOL'], $o->getServerProtocol());
		$this->assertEquals($aServer['HTTP_IF_MODIFIED_SINCE'], $o->getIfModifiedSince());
		$this->assertEquals($aServer['HTTP_IF_NONE_MATCH'], $o->getIfNoneMatch());
	}

}
class ServerRequest_underTest_initServer {
	use ServerRequest;

	public function setAuthentication (HttpAuthenticationA $oHttpAuthentication) {
		return true;
	}
}
