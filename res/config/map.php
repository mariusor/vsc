<?php
/**
 * This file is included in the SiteMapA::loadSiteMap () function
 * It should be used to load other sitemaps or point to specific controllers
 *
 * OBS: make sure you put the specific regular expressions at the top
 * 		of the sitemap so they will be tried before the more generic ones
 *
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.16
 */

/* @var $this \vsc\application\sitemaps\RwSiteMap */

if (!($this instanceof \vsc\application\sitemaps\SiteMapA)) {
	return;
}

// this will break if the current map is the first loaded
$this->getCurrentModuleMap()->setMainTemplatePath(VSC_RES_PATH.'templates');
$this->getCurrentModuleMap()->setMainTemplate('main.php');

//$oMap = $this->map ('.+', \vsc\application\processors\EmptyProcessor::class);
//$oMap->setTemplate ('content.php');

// @TODO
//$oMap = $this->map ('vsc:test/\Z', \vsc\application\processors\TestProcessor::class);
//$oMap->setTemplate ('tmain.php');

//$oMap = $this->map ('.+', \vsc\application\processors\EmptyProcessor::class);
//$oMap->setTemplate ('content.php');

// fallback 404 processor for everything
$oMap = $this->map('(.*)\Z', \vsc\application\processors\NotFoundProcessor::class);
$oMap->setTemplatePath(VSC_RES_PATH.'templates');
$oMap->setTemplate('404.php');

// front controllers
//$this->getCurrentModuleMap()->map('\.json$', \vsc\application\controllers\JsonController::class);
//$this->getCurrentModuleMap()->map('\.rss$', \vsc\application\controllers\RssController::class);
//$this->getCurrentModuleMap()->map('\.txt$', \vsc\application\controllers\PlainTextController::class);
$this->getCurrentModuleMap()->map('\A.*\Z', \vsc\application\controllers\Html5Controller::class);

