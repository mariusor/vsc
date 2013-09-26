<?php
interface vscAuthenticatedProcessorI {
	public function handleAuthentication (vscHttpAuthenticationA $oHttpAuthentication);
}