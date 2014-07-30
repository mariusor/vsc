<?php
/**
 * @package vsc_res_application
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\application\controllers;

vsc\import ('presentation/views');
vsc\import ('application/controllers');
class vscJsonController extends vscCacheableControllerA implements vscJsonControllerI {
	public function getDefaultView () {
		return new vscJsonView();
	}
}