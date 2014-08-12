<?php
/**
 * @package presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
namespace vsc\presentation\responses;

use vsc\domain\models\ErrorModel;
use vsc\infrastructure\vsc;
use vsc\infrastructure\Null;
use vsc\infrastructure\Object;
use vsc\presentation\requests\CLIRequest;
use vsc\presentation\requests\HttpRequestTypes;
use vsc\presentation\views\ViewA;

abstract class HttpResponseA extends Object {
	static protected $aStatusList = array(
		200 => '200 OK',
		201 => '201 Created',
		202 => '202 Accepted',
		204 => '204 No Content',
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other',
		304 => '304 Not Modified',
		400 => '400 Bad Request',
		401 => '401 Unauthorized',
		402 => '402 Payment Required',
		403 => '403 Forbidden',
		404 => '404 Not Found',
		405 => '405 Method Not Allowed',
		406 => '406 Not Acceptable',
		408 => '408 Request Timeout',
		409 => '409 Conflict',
		410 => '410 Gone',
		415 => '415 Unsupported Media Type',
		426 => '426 Update Required',
		500 => '500 Internal Server Error',
		501 => '501 Not Implemented',
	);
	private $sServerProtocol;

	private $iStatus;

	private $aAllow					= array (HttpRequestTypes::GET, HttpRequestTypes::POST, HttpRequestTypes::PUT, HttpRequestTypes::DELETE);
	private $sCacheControl;
	private $sContentEncoding;
	private $sContentLanguage;
	private $iContentLength;
	private $sContentLocation;
	private $sContentDisposition;
	private $sContentMd5;
	protected $sContentType;
	private $sDate;
	private $sETag;
	private $sExpires;
	private $sLastModified;
	private $sLocation;

	private $aHeaders;

	public function getStatusList () {
		return self::$aStatusList;
	}

	private $oView;

	public function __construct () {
		if (is_array($_SERVER)) {
			if (array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
				$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
			}
		}
	}

	public function setStatus ($iStatus) {
		if (!isset (self::$aStatusList[$iStatus])){
			throw new ExceptionResponse('[' . $iStatus . '] is not a valid ' . $this->getServerProtocol() . ' status');
		}

		$this->iStatus = $iStatus;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setLocation ($sValue){
		$this->sLocation = $sValue;
	}

	public function addHeader ($sName, $sValue) {
		$this->aHeaders[$sName]		= $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setCacheControl ($sValue){
		$this->sCacheControl = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentEncoding ($sValue){
		$this->sContentEncoding = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentLanguage ($sValue){
		$this->sContentLanguage = $sValue;
	}

	/**
	 * @param $iValue
	 * @internal param string $sValue
	 * @return void
	 */
	public function setContentLength ($iValue){
		$this->iContentLength = $iValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentLocation ($sValue){
		$this->sContentLocation = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentDisposition ($sValue){
		$this->sContentDisposition = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentMd5 ($sValue){
		$this->sContentMd5 = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setContentType ($sValue){
		$this->sContentType = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setDate ($sValue){
		$this->sDate = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setETag ($sValue){
		$this->sETag = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setExpires ($sValue){
		$this->sExpires = $sValue;
	}

	/**
	 * @param string $sValue
	 * @return void
	 */
	public function setLastModified ($sValue){
		$this->sLastModified = $sValue;
	}

	/**
	 * @return string
	 */
	public function getLocation (){
		return $this->sLocation;
	}

	/**
	 * @return string
	 */
	public function getCacheControl (){
		return $this->sCacheControl;
	}

	/**
	 * @return string
	 */
	public function getContentEncoding (){
		return $this->sContentEncoding;
	}

	/**
	 * @return string
	 */
	public function getContentLanguage (){
		return $this->sContentLanguage;
	}

	/**
	 * @return integer
	 */
	public function getContentLength (){
		return $this->iContentLength;
	}

	/**
	 * @return string
	 */
	public function getContentLocation (){
		return $this->sContentLocation;
	}

	/**
	 * @return string
	 */
	public function getContentDisposition (){
		return $this->sContentDisposition;
	}

	/**
	 * @return string
	 */
	public function getContentMd5 (){
		return $this->sContentMd5;
	}

	/**
	 * @return string
	 */
	public function getContentType (){
		return $this->sContentType;
	}

	/**
	 * @return string
	 */
	public function getDate (){
		return $this->sDate;
	}

	/**
	 * @return string
	 */
	public function getETag (){
		return $this->sETag;
	}

	/**
	 * @return string
	 */
	public function getExpires (){
		return $this->sExpires;
	}

	/**
	 * @return string
	 */
	public function getLastModified (){
		return $this->sLastModified;
	}

	/**
	 * @return string
	 */
	public function getServerProtocol () {
		return $this->sServerProtocol;
	}

	static public function getHttpStatusString ($sProtocol, $iStatus) {
		return $sProtocol . ' ' . self::$aStatusList[$iStatus];
	}

	public function getStatus () {
		return $this->iStatus;
	}

	public function outputHeaders () {
		if (headers_sent()) return true;
		if ($this->getStatus())
			header (self::getHttpStatusString ($this->getServerProtocol(), $this->getStatus()));

		$sLocation = $this->getLocation();
		if ($sLocation) {
			header ('Location:' . $sLocation);
			return;
			// end headers
		}

		$sContentType = $this->getContentType();
		if ($sContentType) {
			header ('Content-Type:' . $sContentType);
		}
		$sCacheControl = $this->getCacheControl();
		if ($sCacheControl) {
			header ('Cache-Control: ' . $sCacheControl);
		}
		$sContentDisposition = $this->getContentDisposition();
		if ($sContentDisposition) {
			header ('Content-Disposition: ' . $sContentDisposition);
		}
		$sContentEncoding = $this->getContentEncoding();
		if ($sContentEncoding) {
			header ('Content-Encoding:' . $sContentEncoding);
		}
		$sContentLanguage = $this->getContentLanguage();
		if ($sContentLanguage) {
			header ('Content-Language:' . $sContentLanguage);
		}
		$iContentLength = $this->getContentLength();
		if ($iContentLength !== null) {
			header ('Content-Length:' . $iContentLength);
		}
		$sContentLocation = $this->getContentLocation();
		if ($sContentLocation) {
			header ('Content-Location:' . $sContentLocation);
		}
		$sMd5 = $this->getContentMd5();
		if ($sMd5) {
			header ('Content-MD5:' . $sMd5);
		}
		$sDate = $this->getDate();
		if ($sDate) {
			header ('Date:' . $sDate);
		}
		$sETag = $this->getETag();
		if ($sETag) {
			header ('ETag: "' . $sETag . '"'); // the ETag is enclosed in quotes (i imagine it's because it might contain EOL's ?)
		}
		$sExpires = $this->getExpires();
		if ($sExpires) {
			header ('Expires:' . $sExpires);
		}
		$sLastModified = $this->getLastModified();
		if ($sLastModified) {
			header ('Last-Modified:' . $sLastModified);
		}
		if (is_array($this->aHeaders )) {
			foreach ($this->aHeaders as $sHeaderName => $sHeaderValue) {
				if (is_null($sHeaderValue)) {
					header_remove($sHeaderName);
				} else {
					header ($sHeaderName . ':' . $sHeaderValue);
				}
			}
		}
	}

	/**
	 * @param ViewA $oView
	 * @return string
	 */
	public function setView (ViewA $oView) {
		$this->oView = $oView;
	}

	/**
	 * @returns ViewA
	 */
	public function getView() {
		if (!ViewA::isValid($this->oView)) {
			$this->oView = new Null();
		}
		return $this->oView;
	}

	public function getOutput() {
		$sResponseBody = null;
		if (ViewA::isValid($this->getView())) {
			$this->setContentType($this->getView()->getContentType());
		} else {
			$this->setContentType('*/*');
		}

		$oRequest = vsc::getEnv()->getHttpRequest();
		try {
			if (CLIRequest::isValid($oRequest) || !$oRequest->isHead() && !$this->isRedirect()) {
				$oView = $this->getView();
				$sResponseBody = $oView->getOutput();
			}
		} catch (ExceptionResponseError $r) {
			$this->setStatus($r->getCode());
			$oView->setModel(new ErrorModel($r));

			$sResponseBody = $oView->getOutput();
		}
		return $sResponseBody;
	}

	public function isSuccess() {
		return ($this->getStatus() == 200);
	}

	public function isRedirect() {
		return ($this->getStatus() >= 300 && $this->getStatus() < 400);
	}

	public function isUserError() {
		return ($this->getStatus() >= 400 && $this->getStatus() < 500);
	}

	public function isServerError() {
		return ($this->getStatus() > 500 && $this->getStatus() < 600);
	}

	public function isError() {
		return ($this->isUserError() || $this->isServerError());
	}
}
