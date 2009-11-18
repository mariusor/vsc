<?php
/**
 * This file is included in the vscSiteMap::load () function
 * It should be used to load other sitemaps or point to specific controllers
 *
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.16
 */

/* @var $this vscRwSiteMap */
$this->map ('test', VSC_RES_PATH . 'application/processors/vsctestprocessor.class.php');
$this->map ('.*', VSC_RES_PATH . 'application/processors/vsc404processor.class.php');

// front controllers
$this->mapController ('xml$', VSC_RES_PATH . 'application/controllers/vschtmlcontroller.class.php');
$this->mapController ('rss$', VSC_RES_PATH . 'application/controllers/vscrsscontroller.class.php');


// fallback 404 processor
$sTest = $this->getBasePath();
$this->setBasePath('^/'); // setting the base regex to the main map path so this works for all files not matching anything else
$this->map ('.*', VSC_RES_PATH . 'application/processors/vsc404processor.class.php');
$this->setBasePath($sTest);