<?php
namespace mocks\presentation\responses;


use vsc\presentation\responses\HttpResponse;

class ResponseFixture extends HttpResponse {
	public function getHeader ($sHeader) {
		return array_key_exists($sHeader, $this->aHeaders) ? $this->aHeaders[$sHeader] : null;
	}
}
