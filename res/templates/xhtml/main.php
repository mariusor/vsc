<?php /* @var $this vscXhtmlView */ ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<title><?php echo $this->getModel()->getTitle(); ?></title>
<?php if (count($this->getStyles ())>=1) {?>
	<style type="text/css">
<?php
foreach ($this->getStyles() as $sMedia => $aStyles) {
	foreach ($aStyles as $sPath ) {
?>
		@import url(<?php echo $sPath; ?>) <?php echo ($sMedia ? $sMedia : '') ?>
<?php
	}
}
?>
	</style>
<?php }  ?>
<?php foreach ($this->getMetaHeaders() as $aMeta) { ?>
	<meta <?php
	foreach ($aMeta as $sName => $sValue) {
		echo $sKey .'="'.$sValue.'"';
	}
	?> />
<?php } ?>
</head>
<body>
<div>
	<!-- hic sunt leones -->
<?php
	echo $this->fetch ($this->getTemplate());
?>

	<!-- /hic sunt leones -->
</div>
</body>
<?php
foreach ($this->getScripts() as $aScript) {
?>
<!--	<script type="text/javascript" src="<?php echo $aScript['path'];?>" />-->
<?php
}
?>
</html>