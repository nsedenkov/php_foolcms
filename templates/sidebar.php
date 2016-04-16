<aside class="mainaside">
<?php
$widgets = \FoolCMS\ObjRegistry::get("widget");
foreach ($widgets as $wid) {
    echo  \FoolCMS\FoolObject::initial("widget")->get($wid);
}
?>
</aside>
