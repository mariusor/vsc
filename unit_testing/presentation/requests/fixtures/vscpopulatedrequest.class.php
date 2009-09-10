<?php
import ('presentation/requests');

class vscPopulatedRequest extends vscHttpRequestA {
	private $aTaintedVars		= array(
		'module'	=> 'test',
		'cucu'		=> 'mucu',
		'height'	=> 143
	);

	private $sHttpMethod		= 'GET';

	private $aGetVars		= array('cucu' => 'pasare');
	private $aPostVars		= array();
	private $aCookieVars		= array('user' => 'asddsasdad234');

	private $sReferer		= 'http://test.com/fixtures/index.html?module=test';
	private $sUserAgent		= 'WGET 2/3';
}
