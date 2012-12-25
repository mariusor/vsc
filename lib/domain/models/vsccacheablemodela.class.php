<?php
/**
 * @package domain
 * @subpackage models
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
import ('infrastructure/caching');
abstract class vscCacheableModelA extends vscModelA implements vscCacheableI {
	abstract public function getLastModified ();
}