<?php
/**
 * @package application
 * @subpackage processors
 * @author marius orcsik <marius@habarnam.ro>
 * @date 26.09.13
 */
namespace vsc\application\processors;

use vsc\presentation\requests\HttpAuthenticationA;

interface AuthenticatedProcessorInterface {
	public function handleAuthentication(HttpAuthenticationA $oHttpAuthentication);
}
