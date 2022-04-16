<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('ATTENDANCE');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$take_attend = new Dec_Take_Attendance($classes);//declared in page_view.php
$take_attend->dec_form();
show_footer();
?>