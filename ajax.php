<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}

$action = $_POST['action'];
if (empty($action)) {return;}

if (file_exists("include/include.php")) {
    require_once "include/include.php";
}
else { die("Critical Caraul::Cannot find includes file"); }

if (defined("_ROOT_DIR_") && defined("_CLASS_DIR_") && file_exists(_ROOT_DIR_ . "/". _CLASS_DIR_ ."/FoolCMS/Dbaccess.php")) {
    require_once _ROOT_DIR_ . "/". _CLASS_DIR_ ."/FoolCMS/Dbaccess.php"; //Подключаем БД
}
else { die("Critical Caraul::Cannot connect to DB"); }

use \FoolCMS\Dbaccess as DBA;

require_once _ROOT_DIR_ . "/". _CLASS_DIR_ ."/mailsender.php";
require_once _ROOT_DIR_ . "/". _CLASS_DIR_ ."/mailvalidator.php";

switch ($action) {
    case 'new_qstn':
        $in = array (
            subject => $_POST['subject'],
            name => $_POST['name'],
            email => $_POST['email'],
            message => $_POST['message']
        );
        extract($in);
        $ownname = DBA::getInstance()->getOneGeneral("fool_author");
        $ownhdr = DBA::getInstance()->getOneGeneral("fool_header");
        $ownmail = DBA::getInstance()->getOneGeneral("fool_email");
        $nrmail = "no-reply@sedenkov.xyz";
        $encoding = "UTF-8";
        $res = array();
        $m_val = new \MailValidator($email);
        if ($m_val->isValid() === true) /*&& ($m_val->isExists() === true)*/ {
            $res['q_id'] = DBA::getInstance()->saveNewMsg($in);
            $subject .= " - from $ownhdr";
            // отправляем сообщение себе
            $mailres = \MailSender::getInstance()->send(
                                                        $name,
                                                        $email,
                                                        $ownname,
                                                        $ownmail,
                                                        $encoding,
                                                        $encoding,
                                                        $subject,
                                                        $message
                                                      );
            // отправляем уведомление посетителю
            $subject = "Сообщение на сайте $ownhdr";
            $message = "Вы создали сообщение № " . $res['q_id'] . " на сайте $ownhdr";
            $mailres = \MailSender::getInstance()->send(
                                                        $ownhdr,
                                                        $nrmail,
                                                        $name,
                                                        $email,
                                                        $encoding,
                                                        $encoding,
                                                        $subject,
                                                        $message
                                                      );
        }
        else {
            $mailres = false;
        }
        if($res['q_id'] > -1 && $mailres !== false) {
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
