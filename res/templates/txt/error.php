<?php $e = $model->getException(); ?>
Internal Error <?php echo $e->getMessage(); ?>

Triggered in <?php echo  $e->getFile() ?> at line <?php  $e->getLine(); ?>

<?php echo $e->getTraceAsString(); ?>

