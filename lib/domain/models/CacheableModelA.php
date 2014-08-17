<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\domain\models;

use vsc\infrastructure\caching\CacheableI;

abstract class CacheableModelA extends ModelA implements CacheableI {
	abstract public function getLastModified ();
}
