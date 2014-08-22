<?php
/**
 * @package presentation
 * @subpackage views
 * @author marius orcsik <marius@habarnam.ro>
 * @date 2010.04.09
 */
namespace vsc\presentation\views;

use vsc\domain\models\ModelA;
use vsc\infrastructure\vsc;

class JsonView extends ViewA implements JsonViewI {
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
			if (\vsc\isDebug()) {
				$flags |= JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
			}
		}
		if (ModelA::isValid($oModel)) {
			/* @var ModelA $oModel */
			$sOutput = json_encode ($oModel->toArray(), $flags );
		} else {
			$sOutput = json_encode ($oModel, $flags );
		}

		if (!json_last_error()) {
			return $sOutput;
		} else {
			throw new ExceptionView (json_last_error_msg());
		}
	}
}
