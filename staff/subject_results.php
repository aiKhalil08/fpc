<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('ADD RESULTS');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Subject_Classes_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
$view_res = new Dec_View_Results($classes, $period);//declared in page_view.php
$view_res->dec_form();
show_footer();
?>