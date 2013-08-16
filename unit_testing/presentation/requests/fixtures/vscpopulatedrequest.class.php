<?php
import ('presentation/requests');
$_GET		= array ('ana' => 'are', 'mere' => '');
$_POST		= array ('postone' => 'are', 'ana' => '');
$_SERVER	= array ('SERVER_SOFTWARE' => 'lighttpd', 'PHP_SELF' => '/', 'REQUEST_URI' => '/ana:are/test:123/');

class vscPopulatedRequest extends vscHttpRequestA {
	private $aTaintedVars		= array(
		'module'	=> 'test',
		'cucu'		=> 'mucu',
		'height'	=> 143
	);

	private $sHttpMethod	= 'GET';

	private $aGetVars		= array('cucu' => 'pasare');
	private $aPostVars		= array();
	private $aCookieVars	= array('user' => 'asddsasdad234');

	private $sReferer		= 'http://localhost/fixtures/index.html?module=test';
	private $sUserAgent		= 'WGET 2/3';

	public function getUri ($bUrlDecode = false) {
		return '/test';
	}
}
