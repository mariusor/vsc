<?php
class vscHttpResponseType {
	public static function getStatus ($iStatus) {
		return isset (static::$aStatus[$iStatus]) ?  static::$aStatus[$iStatus] : static::$aStatus[500];
	}

	public static function isValidStatus ($iStatus) {
		return key_exists($iStatus, static::$aStatus);
	}

	private static $aStatus = array (
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
}
