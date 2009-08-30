<?php
/**
 * @package vsc_controllers
 * @subpackage vsc_responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscHttpResponseA {
//	protected $aStatusList = array(
////		200 => '200 OK',
////		204 => '204 No Content',
////		301 => '301 Moved Permanently',
////		302 => '302 Found',
////		303 => '303 See Other',
////		304 => '304 Not Modified',
////		403 => '403 Forbidden',
////		404 => '404 Not Found',
////		415 => '415 Unsupported Media Type',
////		426 => '426 Update Required',
////		500 => '500 Internal Server Error',
////		501 => '501 Not Implemented',
//	);
	private $sServerProtocol 		= 'HTTP/1.1';

	private $aAllow					= array ('GET', 'POST', 'HEAD');
	private $sCacheControl			= '';
	private $sContentEncoding		= '';
	private $sContentLanguage		= '';
	private $iContentLength			= 0;
	private $sContentLocation		= '';
	private $sContentDisposition	= '';
	private $sContentMd5			= '';
	private $sContentType			= '';
	private $sDate					= '';
	private $sETag					= '';
	private $sExpires				= '';
	private $sLastModified			= '';
	private $sLocation				= '';

	private $sResponseBody;

	/**
	 * @return string
	 */
	public function getServerProtocol () {
		if (!$this->sServerProtocol) {
			$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
		}

		return $this->sServerProtocol;
	}

	public function getStatus ($iStatus) {
		if (!key_exists ($iStatus, $this->aStatusList)){
			throw new vscExceptionResponse('[' . $iStatus . '] is not a valid ' . $this->getServerProtocol() . ' status');
		}

		return ' ' . $this->aStatusList[$iStatus];
	}

	abstract public function getOutput();
}