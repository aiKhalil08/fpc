<?php
require '../bin/contr.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
if (!$_REQUEST) header('../index.php');
$type = $_GET['pe'];
$username = $_GET['me'];
show_header('SEND MAIL');
if (!$_REQUEST) header('location: ./send_mail.php');
$receipient = $_POST['receipient'];
$title = $_POST['mail_title'];
$mail = $_POST['mail_message'];
if ($_FILES['appendages']['name'][0]) {
	$appendages = $_FILES['appendages'];
} else {
	$appendages = false;
}
$send_type = $type;
$send_username = $username;
$rec_type = $_POST['type'];
$send_mail = new Send_Mail($send_type, $send_username, $rec_type, $receipient, $title, $mail, $appendages);//declared in contr.php
$send_mail->amalg_send_mail();
?>