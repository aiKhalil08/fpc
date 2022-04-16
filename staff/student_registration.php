<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('STUDENTS REGISTRATION');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
$sub_reg = new Dec_Subjects_Registration($classes, $period);//declared in page_view.php
$sub_reg->dec_form();
show_footer();
?>