<?php
/**
 * @package vsc_presentation
 * @subpackage responses
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.30
 */
abstract class vscHttpResponseA {
	protected $aStatusList = array(
		200 => '200 OK',
		204 => '204 No Content',
		301 => '301 Moved Permanently',
		302 => '302 Found',
		303 => '303 See Other',
		304 => '304 Not Modified',
		403 => '403 Forbidden',
		404 => '404 Not Found',
		415 => '415 Unsupported Media Type',
		426 => '426 Update Required',
		500 => '500 Internal Server Error',
		501 => '501 Not Implemented',
	);
	private $sServerProtocol;

	private $iStatus;

	private $aAllow					= array ('GET', 'POST', 'HEAD');
	private $sCacheControl;
	private $sContentEncoding;
	private $sContentLanguage;
	private $iContentLength;
	private $sContentLocation;
	private $sContentDisposition;
	private $sContentMd5;
	private $sContentType;
	private $sDate;
	private $sETag;
	private $sExpires;
	private $sLastModified;
	private $sLocation;

	private $aHeaders;

//	private $sResponseBody;

	public function setStatus ($iStatus) {
		if (!key_exists ($iStatus, $this->aStatusList)){
			throw new vscExceptionResponse('[' . $iStatus . '] is not a valid ' . $this->getServerProtocol() . ' status');
		}

		$this->iStatus = $iStatus;
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
	 * @param string $sValue
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
	 * @param string $sValue
	 * @return void
	 */
	public function setLocation ($sValue){
		$this->sLocation = $sValue;
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
	public function getLocation (){
		return $this->sLocation;
	}

	/**
	 * @return string
	 */
	public function getServerProtocol () {
		if (!$this->sServerProtocol) {
			$this->sServerProtocol = $_SERVER['SERVER_PROTOCOL'];
		}

		return $this->sServerProtocol;
	}

	public function getHttpStatusString () {
		return $this->getServerProtocol() . ' ' . $this->aStatusList[$this->getStatus()];
	}

	public function getStatus () {
		return $this->iStatus;
	}

	public function outputHeaders () {
		if ($this->getStatus())
			header ($this->getHttpStatusString ());

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
		if ($iContentLength) {
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
		$sContentType = $this->getContentType();
		if ($sContentType) {
			header ('Content-Type:' . $sContentType);
		}
		$sDate = $this->getDate();
		if ($sDate) {
			header ('Date:' . $sDate);
		}
		$sETag = $this->getETag();
		if ($sETag) {
			header ('ETag:' . $sETag);
		}
		$sExpires = $this->getExpires();
		if ($sExpires) {
			header ('Expires:' . $sExpires);
		}
		$sLastModified = $this->getLastModified();
		if ($sLastModified) {
			header ('Last-Modified:' . $sLastModified);
		}
		// dunno if I need this
		$sLocation = $this->getLocation();
		if ($sLocation) {
			header ('Location:' . $sLocation);
		}
	}
	protected $sResponseBody;

	public function setContentBody ($oBody) {
		/* @var $oBody vscResponseBody */
		$this->sResponseBody = $oBody->getOutput();
	}

	abstract public function getOutput();
}