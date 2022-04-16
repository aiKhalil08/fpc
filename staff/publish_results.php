<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('PUBLISH RESULTS');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$pub_res = new Dec_Publish_Results($classes);//declared in page_view.php
$pub_res->dec_form();
show_footer();
?>