<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.11.19
 */
namespace vsc\domain\models;

interface HttpModelInterface extends ModelInterface {
	public function getPageTitle();
}
