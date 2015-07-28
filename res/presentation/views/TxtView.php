<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\presentation\views;

class TxtView extends ViewA implements ViewI {
	protected $sContentType = 'text/plain';
	protected $sFolder = 'txt';
}
