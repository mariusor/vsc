<?php
namespace vsc\application\sitemaps;

interface ContentTypeMappingI {
	public function setMainTemplatePath($sPath);

	public function getMainTemplatePath();

	public function setMainTemplate($sPath);

	public function getMainTemplate();
}
