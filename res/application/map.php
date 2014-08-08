<?php
/**
 * This file is included in the vscSiteMap::load () function
 * It should be used to load other sitemaps or point to specific controllers
 *
 * OBS: make sure you put the specific regular expressions at the top
 * 		of the sitemap so they will be tried before the more generic ones
 *
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.16
 */

/* @var $this \vsc\application\sitemaps\RwSiteMap */

// this will break if the current map is the first loaded
$this->getParentModuleMap()->setMainTemplatePath(VSC_RES_PATH . 'templates');
$this->getParentModuleMap()->setMainTemplate('main.php');
$this->getCurrentModuleMap()->setTemplatePath (VSC_RES_PATH . 'templates');

//$oMap = $this->map ('vsc/\Z', VSC_RES_PATH . 'application/processors/vscemptyprocessor.php');
//$oMap->setTemplate ('content.php');

// @TODO
//$oMap = $this->map ('vsc:test/\Z', VSC_RES_PATH . 'application/processors/vsctestprocessor.php');
//$oMap->setTemplate ('tmain.php');

//$oMap = $this->map ('.+', VSC_RES_PATH . 'application/processors/vscemptyprocessor.php');
//$oMap->setTemplate ('content.php');

// fallback 404 processor for everything
$oMap = $this->map ('(.+)\Z', VSC_RES_PATH . 'application/processors/vscemptyprocessor.php');
$oMap->setTemplate ('404.php');

// front controllers
//$this->getCurrentModuleMap()->mapController ('\.json$', VSC_RES_PATH . 'application/controllers/vscjsoncontroller.php');
$this->getCurrentModuleMap()->mapController ('\.rss$', VSC_RES_PATH . 'application/controllers/vscrsscontroller.php');
$this->getCurrentModuleMap()->mapController ('\.txt$', VSC_RES_PATH . 'application/controllers/vscplaintextcontroller.php');
$this->getCurrentModuleMap()->mapController ('^.*$', VSC_RES_PATH . 'application/controllers/vscxhtmlcontroller.php');

// d ($oMap->getModuleMap(), $this->getCurrentModuleMap());
