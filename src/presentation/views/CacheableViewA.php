<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
namespace vsc\presentation\views;

use vsc\infrastructure\caching\CacheableInterface;

abstract class CacheableViewA extends ViewA implements CacheableInterface {
	abstract public function getMTime();
}
