<?php

/* @var $this \vsc\application\sitemaps\vscRwSiteMap */
$this->getCurrentModuleMap()->setTemplatePath(VSC_FIXTURE_PATH . 'templates' . DIRECTORY_SEPARATOR );
$oMap = $this->map ('test', '_fixtures\\application\\processors\\testFixtureProcessor');

$oMap->mapController('.*', '_fixtures\\application\\controllers\\vscGenericFrontController');

