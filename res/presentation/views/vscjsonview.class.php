<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\presentation\views;

vsc\import ('presentation/views');
class vscJsonView extends vscViewA implements vscJsonViewI {
	protected $sContentType = 'application/json';
	protected $sFolder = 'json';
	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#append($tpl_var, $value, $merge)
	 */
	public function append ($tpl_var, $value=null, $merge=false) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#assign($tpl_var, $value)
	 */
	public function assign ($tpl_var, $value = null) {}

	/**
	 * (non-PHPdoc)
	 * @see lib/presentation/views/vscViewI#display($resource_name, $cache_id, $compile_id)
	 */
	public function display ($resource_name) {}

	public function outputModel ($oModel) {
		$flags = 0;//JSON_FORCE_OBJECT;

		if (phpversion() > '5.3.3') {
			$flags |= JSON_NUMERIC_CHECK;
		}
		if (phpversion() > '5.4.0') {
			$flags |= JSON_UNESCAPED_UNICODE;
			if (isDebug()) {
				$flags |= JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
			}
		}
		if (vscModelA::isValid($oModel)) {
			/* @var $oModel vscModelA */
			return json_encode ($oModel->toArray(), $flags );
		} else {
			return json_encode ($oModel, $flags );
		}
	}
}
