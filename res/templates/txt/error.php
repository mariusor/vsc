<?php
use \vsc\infrastructure\vsc;
/** @var \vsc\domain\models\ErrorModel $model */
$e = $model->getException(); ?>
Internal Error <?php echo $e->getMessage(); ?>
<?php if (vsc::getEnv()->isDevelopment()) {?>
Triggered in <?php echo  $e->getFile() ?> at line <?php  $e->getLine(); ?>

<?php echo $e->getTraceAsString(); ?>

<?php } ?>
