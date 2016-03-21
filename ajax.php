<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}

$action = $_POST['action'];
if (empty($action)) {return;}

if (file_exists("include/include.php")) {
    require_once "include/include.php";
}
else { die("Critical Caraul::Cannot find includes file"); }

if (defined("_ROOT_DIR_") && defined("_CLASS_DIR_") && file_exists(_ROOT_DIR_ . "/". _CLASS_DIR_ ."/dbaccess.php")) {
    require_once _ROOT_DIR_ . "/". _CLASS_DIR_ ."/dbaccess.php"; //Подключаем БД
}
else { die("Critical Caraul::Cannot connect to DB"); }

switch ($action) {
    case 'new_qstn':
        $in = array (
            subject => $_POST['subject'],
            name => $_POST['name'],
            email => $_POST['email'],
            message => $_POST['message']
        );
        extract($in);
        mail('sedenkoff@inbox.ru', $subject, $message, "From: $email");
        $res = array();
        $res['q_id'] = FoolDB::getInstance()->saveNewMsg($in);
        if($res['q_id'] > -1) {
            $res['status'] = 'Ok';
        }
        else {
            $res['status'] = 'Fail';
        }
        if($res){
            echo json_encode($res);
        }
        break;
    default:
        break;
}
?>
