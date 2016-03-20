<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}

$action = $_POST['action'];
if (empty($action)) {return;}

switch ($action) {
    case 'new_qstn':
        $res = array();
        $res['q_id'] = mt_rand(0,1000);
        $res['status'] = 'Ok';
        if($res){
            echo json_encode($res);
        }
        mail('sedenkoff@inbox.ru', $_POST['subject'], $_POST['message']);
        break;
    default:
        break;
}
?>
