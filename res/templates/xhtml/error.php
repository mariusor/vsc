<style>ul {padding:0; font-size:0.8em} li {padding:0.2em;display:inline} address {position:fixed;bottom:0;}</style>

<?php $e = $model->getException(); ?>
<strong>Internal Error <?php echo (!$e ? '' : ': '. $e->getMessage()); ?></strong>
<address>&copy; VSC</address>
<ul>
	<li>
		<a href="#" onclick="p = document.getElementById('trace'); if (p.style.display=='block') p.style.display='none';else p.style.display='block'; return false">toggle trace</a>
	</li>
	<li>
		<a href="javascript: p = document.getElementById('trace'); document.location.href ='mailto:<?php echo ROOT_MAIL ?>?subject=Problems&amp;body=' + p.innerHTML; return false">mail me</a>
	</li>
</ul>

<p style="font-size:.8em">Triggered in <strong><?php echo $e->getFile() ?></strong> at line <?php $e->getLine();?> </p>

<pre style="position:fixed;bottom:2em;display:none;font-size:.8em" id="trace">
<?php echo $e->getTraceAsString(); ?>
</pre>
