<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2012.08.26
 */
abstract class vscCacheableViewA extends vscViewA implements vscCacheableI {
	abstract public function getMTime ();
}