<?php
require '../bin/contr.php';
require_once '../bin/start_session.php';
require '../bin/view.php';
require '../bin/page_view.php';
show_header('MAIL');
if (!$_REQUEST) header('../index.php');
$type = $_GET['pe'];
$username = $_GET['me'];
show_header('READ MAIL');
$id = $_GET['id'];
$read = new Read_Mails($id, $type, $username);//declared in view.php
$read->read_xml();
show_footer();
?>