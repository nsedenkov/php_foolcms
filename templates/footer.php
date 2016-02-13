<footer class="footer">
<div class="copyrigth">
<?php
$year = $engine->_fooldb->getOneGeneral('fool_year');
$auth = $engine->_fooldb->getOneGeneral('fool_author');
?>
<p><strong>&copy; <?php echo "$year, $auth" ?></strong></p>
<p>Powered by FoolCMS</p>
</div>
</footer>
</body>
</html>
