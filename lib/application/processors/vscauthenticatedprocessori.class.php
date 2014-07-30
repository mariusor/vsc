<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 26.09.13
 */
namespace vsc\application\processors;

interface vscAuthenticatedProcessorI {
	public function handleAuthentication (vscHttpAuthenticationA $oHttpAuthentication);
}