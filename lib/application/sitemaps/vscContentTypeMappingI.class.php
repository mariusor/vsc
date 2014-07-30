<?php
namespace vsc\application\sitemaps;

interface vscContentTypeMappingI {
	public function setMainTemplatePath ($sPath) ;

	public function getMainTemplatePath ();

	public function setMainTemplate ($sPath);

	public function getMainTemplate ();
}