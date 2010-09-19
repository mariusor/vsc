<?php
/* @var $this vscRwSiteMap */
$this->setBasePath (BASE_PATH);
import (BASE_PATH . 'controllers/');
$this->map ('(.*)', 'tsMainController');
