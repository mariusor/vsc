<?php
/**
 * This file is included in the vscSiteMap::load () function
 * It should be used to load other sitemaps or point to specific controllers
 *
 * OBS: make sure you put the most specific regular expressions at the top
 * 		of the sitemap so they will be tried before the more generic ones
 *
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.16
 */
/* @var $this vscRwSiteMap */
$this->getModuleMap()->setTemplatePath (VSC_RES_PATH . 'templates');
$this->map ('.*', VSC_RES_PATH . 'application/processors/vsc404processor.class.php');

// front controllers
$this->mapController ('.*\.json$', VSC_RES_PATH . 'application/controllers/vscjsoncontroller.class.php');
$this->mapController ('.*\.rss$', VSC_RES_PATH . 'application/controllers/vscrsscontroller.class.php');
$this->mapController ('.*\.txt$', VSC_RES_PATH . 'application/controllers/vsctxtcontroller.class.php');
$this->mapController ('$', VSC_RES_PATH . 'application/controllers/vscxhtmlcontroller.class.php');

// fallback 404 processor for everything
$sTest = $this->getBasePath();

$this->setBasePath('^/'); // setting the base regex to the main map path so this works for all files not matching anything else
$oMap = $this->map ('.+', VSC_RES_PATH . 'application/processors/vsc404processor.class.php');
$oMap->setTemplate ('content.php');

//$oMap = $this->map ('.*', VSC_RES_PATH . 'application/processors/vscemptyprocessor.class.php');
//$oMap->setTemplate ('content.php');

//$this->setBasePath($sTest);
