<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\presentation\views;

use vsc\infrastructure\caching\vscCacheableI;

abstract class vscCacheableViewA extends vscViewA implements vscCacheableI {
	abstract public function getMTime ();
}
