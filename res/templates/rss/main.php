<?php
/* @var $this \vsc\presentation\views\RssView */
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<atom:link href="<?php echo self::getCurrentUri(); ?>" rel="self" type="application/rss+xml" />
		<title><?php echo htmlspecialchars($this->getTitle(), ENT_QUOTES, 'UTF-8'); ?></title>
		<link><?php echo self::getCurrentSiteUri(); ?></link>
		<description><?php echo htmlspecialchars($this->getDescription(), ENT_QUOTES, 'UTF-8') ?></description>
		<language><?php echo ($this->getLanguage() != '' ? $this->getLanguage() : 'EN') ?></language>
		<lastBuildDate><?php echo ($this->getLastBuildDate() != '' ? $this->getLastBuildDate() : date('%c')); ?></lastBuildDate>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<?php
try {
	$sContent = $this->fetch($this->getTemplate());
} catch (\vsc\ExceptionPath $e) {
	// the template could not be found
}
	if (!empty($sContent)) {
		echo $sContent;
	} else {
		include ('content.php');
	}
?>

	</channel>
</rss>
