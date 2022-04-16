<?php
require '../bin/contr.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
if (!$_REQUEST) header('../index.php');
$type = $_GET['pe'];
$username = $_GET['me'];
show_header('SEND MAIL');
$sent_mails = new View_Mails($type, $username, 'sent');//declared in contr.php
$sent_mails->amalg_view_mails();
?>