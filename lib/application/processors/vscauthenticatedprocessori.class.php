<?php
/**
 * @package vsc_application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 26.09.13
 */
namespace vsc\application\processors;

use vsc\presentation\requests\vscHttpAuthenticationA;

interface vscAuthenticatedProcessorI {
	public function handleAuthentication (vscHttpAuthenticationA $oHttpAuthentication);
}