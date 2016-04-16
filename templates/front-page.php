<h1>Блог поднимателя пингвинов</h1>
<?php
//ObjRegistry::getInstance()->fill();
$posts = \FoolCMS\ObjRegistry::get("post");
foreach ($posts as $postid) {
    echo \FoolCMS\FoolObject::initial("post")->get($postid);
}
?>
