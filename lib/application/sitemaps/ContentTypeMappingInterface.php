<?php
namespace vsc\application\sitemaps;

interface ContentTypeMappingInterface {
	public function setMainTemplatePath($sPath);

	public function getMainTemplatePath();

	public function setMainTemplate($sPath);

	public function getMainTemplate();
}
