<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\domain\models;

// \vsc\import ('infrastructure/caching');
use vsc\infrastructure\caching\vscCacheableI;

abstract class vscCacheableModelA extends vscModelA implements vscCacheableI {
	abstract public function getLastModified ();
}