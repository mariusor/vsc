<?php
/**
 * This file is included in the vscSiteMap::load () function
 * It should be used to load other sitemaps or point to specific controllers
 *
 * @author marius orcsik <marius@habarnam.ro>
 * @date 09.09.16
 */

/* @var $this vscRwSiteMap */
$this->map ('(.*)', VSC_LIB_PATH . 'presentation/processors/vscemptyprocessor.class.php');
