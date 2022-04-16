<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('WRITE COMMENTS');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$type = 'principal';
$select_student = new Dec_Write_Comments($type);//declared in page_view.php
$select_student->dec_select_class();
show_footer();
?>