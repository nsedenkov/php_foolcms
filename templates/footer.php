<footer class="footer">
<div class="copyrigth">
<?php
$res = $engine->_fooldb->exQuery('SELECT id,value FROM general WHERE name=\'fool_year\' ORDER BY id DESC');
if($res->num_rows>0){
    $row = $res->fetch_assoc();
    $year = $row['value'];
}
$res = $engine->_fooldb->exQuery('SELECT id,value FROM general WHERE name=\'fool_author\' ORDER BY id DESC');
if($res->num_rows>0){
    $row = $res->fetch_assoc();
    $auth = $row['value'];
}
?>
<p><strong>&copy; <?php echo "$year, $auth" ?></strong></p>
<p>Powered by FoolCMS</p>
</div>
</footer>
</body>
</html>
