<?php
namespace fixtures\presentation\requests;
$_GET		= array ('ana' => 'are', 'mere' => '');
$_POST		= array ('postone' => 'are', 'ana' => '');
$_SERVER	= array (
	'SERVER_SOFTWARE' => 'lighttpd',
	'PHP_SELF' => '/',
	'REQUEST_URI' => '/test/ana:are/test:123/',
	'HTTP_ACCEPT' => 'application/html,text/html;charset=UTF8,image/*'
);
use vsc\presentation\requests\RwHttpRequest;

class PopulatedRequest extends RwHttpRequest {
	protected $aTaintedVars		= array(
		'module'	=> 'test',
		'cucu'		=> 'mucu',
		'height'	=> 143
	);

	public function __construct() {}

	protected $returnUri = '/test';
	protected $aAccept =  array (
		'application/html',
		'text/html;charset=UTF8',
		'image/*'
	);
	protected $sHttpMethod	= 'GET';

	protected $aGetVars		= array('cucu' => 'pasare','ana' => 'are', 'mere' => '', 'test' => 123);
	protected $aPostVars	= array('postone' => 'are', 'ana' => '');
	protected $aCookieVars	= array('user' => 'asddsasdad234');

	protected $sReferrer	= 'http://localhost/fixturesf/index.html?module=test';
	protected $sUserAgent	= 'WGET 2/3';

	public function setUri ($sUri) {
		$this->sUri = $sUri;
	}

	public function setHttpAccept($sAccepts) {
		$this->aAccept = array ($sAccepts);
	}

	public function setContentType ($sContentType) {
		$this->sContentType = $sContentType;
	}
}
