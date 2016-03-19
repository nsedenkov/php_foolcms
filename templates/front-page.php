<h1>Блог поднимателя пингвинов</h1>
<?php
//ObjRegistry::getInstance()->fill();
$posts = ObjRegistry::get("post");
foreach ($posts as $postid) {
    echo FoolObject::initial("post")->get($postid);
}
?>
