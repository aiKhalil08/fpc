<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('WRITE COMMENTS');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$type = 'class_teacher';
$select_student = new Dec_Write_Comments($type, $classes);//declared in page_view.php
$select_student->dec_select_class();
show_footer();
?>