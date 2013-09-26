<?php
class vscDigestHttpAuthentication extends vscHttpAuthenticationA {
	public function __construct ($sDigestResponse) {
		throw new vscExceptionUnimplemented ('Digest authentication not implemented');
	}
}