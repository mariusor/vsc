<?php
class vscExceptionAuthenticationNeeded extends vscExceptionResponseError {

	public function __construct($sMessage) {
		parent::__construct ($sMessage, 401);
	}
}