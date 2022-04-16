<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('ADD RESULTS');
if (!$_REQUEST) {
	header('location: ./add_results.php');
	die();
}
$ids = $_POST['id'];
$scores = $_POST['score'];
$subject = $_POST['subject'];
$class = $_POST['class'];
$session = $_POST['session'];
$term = $_POST['term'];
$res_type = $_POST['res_type'];
$add = new Add_Results($ids, $scores, $subject, $class, $session, $term, $res_type);//declared in contr.php. adds students results
$add->amalg_add_results();
$send_type = 'admin';
$send_username = 'admin';
$rec_type = 'staff_username';
$receipient = $_COOKIE['staff_username'];
$title = 'UPDATE OF '.strtoupper($class).' '.strtoupper($subject).' RESULTS.';
$mail = 'Hi '.$_COOKIE['staff_first_name'].'. This is to inform you that the results of the following class and subject was edited at '.date('H:i:s, d M, Y').'.'."\n".'CLASS: '.strtoupper($class).'.'."\n".'SUBJECT: '.strtoupper($subject).'.'."\n".'Please discard this mail if you are aware of the change.';
$send_mail = new Send_Mail(base64_encode($send_type), base64_encode($send_username), $rec_type, $receipient, $title, $mail);//declared in contr.php
$send_mail->amalg_send_mail();
?>