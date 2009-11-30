<?php
/**
 * @package vsc_presentation
 * @subpackage controllers
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.08.31
 */
import ('application/presentation/views');
import ('application/controllers');
class vscRssController extends vscFrontControllerA {
	public function getDefaultView () {
		return new vscRssView();
	}
}