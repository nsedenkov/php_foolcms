</div><!-- wrapper -->
<footer class="footer">
<div class="copyright m-top m-bottom m-left">
<?php
$year = $engine->_fooldb->getOneGeneral('fool_year');
$auth = $engine->_fooldb->getOneGeneral('fool_author');
?>
<p><strong>&copy; <?php echo "$year, $auth" ?></strong></p>
</div>
<div class="fright m-top m-bottom m-right">
<p>Powered by FoolCMS</p>
</div>
</footer>
</body>
</html>
