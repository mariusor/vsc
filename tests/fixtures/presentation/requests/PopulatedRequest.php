<?php
namespace fixtures\presentation\requests;
$_GET		= array ('ana' => 'are', 'mere' => '');
$_POST		= array ('postone' => 'are', 'ana' => '');
$_SERVER	= array ('SERVER_SOFTWARE' => 'lighttpd', 'PHP_SELF' => '/', 'REQUEST_URI' => '/ana:are/test:123/', 'SCRIPT_NAME' => 'test.php');

use vsc\presentation\requests\HttpRequestA;

class PopulatedRequest extends HttpRequestA {
	private $aTaintedVars		= array(
		'module'	=> 'test',
		'cucu'		=> 'mucu',
		'height'	=> 143
	);

	protected $returnUri = '/test';
	private $aAccept =  array (
		'application/html',
		'text/html;charset=UTF8',
		'image/*'
	);
	private $sHttpMethod	= 'GET';

	private $aGetVars		= array('cucu' => 'pasare','ana' => 'are', 'mere' => '');
	private $aPostVars		= array('postone' => 'are', 'ana' => '');
	private $aCookieVars	= array('user' => 'asddsasdad234');

	private $sReferer		= 'http://localhost/fixtures/index.html?module=test';
	private $sUserAgent		= 'WGET 2/3';

	public function setReturnUri ($sUri) {
		$this->returnUri = $sUri;
	}

	public function addHttpAccept($sAccepts) {
		$this->aAccept = array ($sAccepts);
	}

	public function getUri ($bUrlDecode = false) {
		return $this->returnUri;
	}
}
