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

/* @var $this vscRwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath (VSC_RES_PATH . 'templates');

$oMap = $this->map ('vsc/', VSC_RES_PATH . 'application/processors/vscemptyprocessor.class.php');
$oMap->setTemplate ('content.php');

// @TODO
//$oMap = $this->map ('vsc/unittest', VSC_RES_PATH . 'application/processors/vscunittestprocessor.class.php');
//$oMap->setTemplate ('main.php');

//$oMap = $this->map ('.+', VSC_RES_PATH . 'application/processors/vscemptyprocessor.class.php');
//$oMap->setTemplate ('content.php');

// fallback 404 processor for everything
$oMap = $this->map ('.*', VSC_RES_PATH . 'application/processors/vsc404processor.class.php');
$oMap->setTemplate ('404.php');

// front controllers
//$this->getCurrentModuleMap()->mapController ('\.json$', VSC_RES_PATH . 'application/controllers/vscjsoncontroller.class.php');
//$this->getCurrentModuleMap()->mapController ('\.rss$', VSC_RES_PATH . 'application/controllers/vscrsscontroller.class.php');
//$this->getCurrentModuleMap()->mapController ('\.txt$', VSC_RES_PATH . 'application/controllers/vsctxtcontroller.class.php');
$this->getCurrentModuleMap()->mapController ('^.*$', VSC_RES_PATH . 'application/controllers/vscxhtmlcontroller.class.php');
