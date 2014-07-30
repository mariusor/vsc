<?php
/**
 * @package vsc_presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2011.02.17
 */
namespace vsc\presentation\views;

// \vsc\import ('presentation/views');
use vsc\domain\models\vscStaticFileModel;

class vscPlainTextView extends vscViewA implements vscViewI {
	protected $sContentType = 'text/plain';
	protected $sFolder = 'txt';

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

	public function fetch ($includePath) {
		$oModel = $this->getModel();
		/* @var $oModel vscStaticFileModel */
		if (vscStaticFileModel::isValid($oModel)) {
			return $oModel->getFileContent();
		} else {
			return parent::fetch($includePath);
		}
	}
}