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
$this->getParentModuleMap()->setMainTemplatePath(VSC_RES_PATH.'templates');
$this->getParentModuleMap()->setMainTemplate('main.php');
$this->getCurrentModuleMap()->setTemplatePath(VSC_RES_PATH.'templates');

//$oMap = $this->map ('.+', \vsc\application\processors\EmptyProcessor::class);
//$oMap->setTemplate ('content.php');

// @TODO
//$oMap = $this->map ('vsc:test/\Z', \vsc\application\processors\TestProcessor::class);
//$oMap->setTemplate ('tmain.php');

//$oMap = $this->map ('.+', \vsc\application\processors\EmptyProcessor::class);
//$oMap->setTemplate ('content.php');

// fallback 404 processor for everything
$oMap = $this->map('(.+)\Z', \vsc\application\processors\NotFoundProcessor::class);
$oMap->setTemplate('404.php');

// front controllers
$this->getCurrentModuleMap()->mapController('\.json$', \vsc\application\controllers\JsonController::class);
$this->getCurrentModuleMap()->mapController('\.rss$', \vsc\application\controllers\RssController::class);
$this->getCurrentModuleMap()->mapController('\.txt$', \vsc\application\controllers\PlainTextController::class);
$this->getCurrentModuleMap()->mapController('^.*$', \vsc\application\controllers\XhtmlController::class);

// d ($oMap->getModuleMap(), $this->getCurrentModuleMap());
