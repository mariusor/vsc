<?php /* @var $this vscXhtmlView */ ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<title><?php $sTitle = $this->getTitle(); echo ($sTitle ? $sTitle : '[null]') ?></title>
<?php
$aAllStyles = $this->getStyles ();
if (count($aAllStyles)>=1) {?>
	<style type="text/css">
<?php
foreach ($aAllStyles as $sMedia => $aStyles) {
	if (is_array($aStyles))
	foreach ($aStyles as $sPath ) {
?>
		@import url("<?php echo $sPath; ?>") <?php echo ($sMedia ? $sMedia : ''); echo ";\n"; ?>
<?php
	}
}
?>
	</style>
<?php }  ?>
<?php
if (count($this->getMetaHeaders()) >= 1) {
	foreach ($this->getMetaHeaders() as $sName => $sValue) { ?>
	<meta <?php
			echo 'name="'.$sName .'" content="'.$sValue.'"';
?> />
<?php
	}
}
?>
<?php
/*
if (is_array ($this->getLinks()) && count($this->getLinks()) >= 1) {
	foreach ($this->getLinks() as $sType => $aLinkContent) {
		foreach ($aLinkContent as $aValue) {
			echo "\t".'<link type="' . $sType .'" ';
			foreach ($aValue as $sKey => $sValue) {
				echo $sKey . '="' . $sValue . '" ';
			}
			echo '/>'."\n";
		}
	}
}*/
?>
</head>
<body>
<div>
	<!-- hic sunt leones -->

<?php
try {
	$sContent = $this->fetch ($this->getTemplate());
} catch (vscExceptionPath $e) {
	// the template could not be found
}
	if (!empty($sContent)) {
		echo $sContent;
	} else {
		include ('content.php');
	}
?>

	<!-- /hic sunt leones -->
</div>
<?php
$aAllScripts = $this->getScripts();
if (count ($aAllScripts) >= 1 ) {
	foreach ($aAllScripts as $sPath) {
?>
<script type="text/javascript" src="<?php echo $sPath;?>"></script>
<?php
	}
}
?>
</body>
</html>
