<?php
/**
 * Created by PhpStorm.
 * User: habarnam
 * Date: 9/6/14
 * Time: 2:07 PM
 */

namespace fixtures\presentation\responses;


use vsc\presentation\responses\HttpResponse;

class FixtureResponse extends HttpResponse {
	public function getHeader ($sHeader) {
		return array_key_exists($sHeader, $this->aHeaders) ? $this->aHeaders[$sHeader] : null;
	}
} 
