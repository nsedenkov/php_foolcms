<aside class="mainaside">
<?php
$widgets = ObjRegistry::get("widget");
foreach ($widgets as $wid) {
    echo FoolObject::initial("widget")->get($wid);
}
?>
</aside>
